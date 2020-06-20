<?php
namespace Centauri\CMS\Http;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Centauri\CMS\Centauri;
use Centauri\CMS\Caches\StaticFileCache;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Utility\DomainsUtility;
use Centauri\CMS\Utility\FixerUtility;

class Request
{
    /**
     * This function manages all requests before anything else happens
     * 
     * @param string $view - Can be either frontend or backend/centauri
     * 
     * @return void
     */
    public static function handle($nodes, $host, $domainType = "default")
    {
        $Centauri = new Centauri();

        $domainFiles = DomainsUtility::findAll();
        $domain = null;

        $hostUri = $host . request()->getRequestUri();

        foreach($domainFiles as $domainFile) {
            $domainValue = $domainFile->content->domain;

            if(is_null($domain)) {
                if($hostUri == $domainValue) {
                    $domain = $domainFile;
                } else if($host == $domainValue) {
                    $domain = $domainFile;
                }
            }
        }

        if(is_null($domain)) {
            throw new Exception("The requested domain could not be resolved");
        }

        $domainConfigJSON = json_decode(file_get_contents($domain));

        if($nodes == "centauri") {
            if(request()->session()->get("CENTAURI_BE_USER")) {
                $Centauri->initBE();
                $localizedArr = \Centauri\CMS\Service\Locales2JSService::getLocalizedArray();

                return view("Centauri::Backend.centauri", [
                    "data" => [
                        "modules" => $GLOBALS["Centauri"]["Modules"],
                        "localizedArr" => $localizedArr,
                        "dashboard" => $_GET["dashboard"] ?? "1"
                    ]
                ]);
            }

            return view("Centauri::Backend.login");
        }

        if(!empty($nodes) && Str::contains($nodes, "/")) {
            $nnodes = explode("/", $nodes);

            if($nnodes[0] == "centauri") {
                if(!request()->session()->get("CENTAURI_BE_USER")) {
                    if($nodes != "centauri/ajax/Backend/login" && $nodes != "centauri/action/Backend/login") {
                        return redirect("/centauri");
                    }
                }

                if($nnodes[1] == "ajax" || $nnodes[1] == "action") {
                    $classname = $nnodes[2];
                    $method = $nnodes[3];

                    $namespace = "\\Centauri\\CMS\\";

                    switch($nnodes[1]) {
                        case "ajax":
                            $class = Centauri::makeInstance($namespace . "Ajax\\" . $classname . "Ajax");
                            $method = "request";
                            break;
                        default:
                            $class = Centauri::makeInstance($namespace . "Controller\\" . $classname . "Controller");
                            $method .= "Action";
                            break;
                    }

                    return call_user_func_array(
                        [
                            $class,
                            $method
                        ],

                        [
                            request(),
                            $nnodes[3]
                        ]
                    );
                } else {
                    if($nnodes[1] == "fix") {
                        $fixID = $nnodes[2];
                        $FixerUtility = Centauri::makeInstance(FixerUtility::class);
                        return $FixerUtility->fix($fixID);
                    }

                    $moduleid = $nnodes[1];

                    $modulesService = Centauri::makeInstance(\Centauri\CMS\Service\ModulesService::class);
                    $modulesService->init();
                    $modules = $modulesService->findDataByModuleid($moduleid);

                    $data = array_merge(
                        [
                            "moduleid" => $moduleid,
                            "modules" => $GLOBALS["Centauri"]["Modules"]
                        ],

                        (gettype($modules) == "array" ? $modules : [])
                    );

                    $title = trans("backend/modules.$moduleid.title");

                    $data["localizedArr"] = \Centauri\CMS\Service\Locales2JSService::getLocalizedArray();
                    $data["dashboard"] = $_GET["dashboard"] ?? "1";

                    return view("Centauri::Backend.centauri", [
                        "title" => $title,
                        "data" => $data
                    ]);
                }
            }
        }

        $page = null;

        if(!empty($nodes) && Str::contains($nodes, "/") && $nodes != "/") {
            $page = Page::where([
                "domain_id" => $domain->content->rootpageuid,
                "slugs" => $nodes
            ])->get()->first();

            if(is_null($page)) {
                $page = Page::where([
                    "domain_id" => $domain->content->rootpageuid,
                    "slugs" => "/" . $nodes
                ])->get()->first();
            }

            $nodes = explode("/", $nodes);
        } else {
            $slugs = str_replace("/", "", $nodes);

            if(!is_null($domain)) {
                if(!empty($nodes)) {
                    $page = Page::where([
                        "domain_id" => $domain->content->rootpageuid,
                        "slugs" => "/" . $slugs
                    ])->get()->first();

                    if(is_null($page)) {
                        $page = Page::where([
                            "uid" => $domain->content->rootpageuid,
                            "slugs" => "/" . $slugs
                        ])->get()->first();
                    }
                } else {
                    $page = Page::where("uid", $domain->content->rootpageuid)->get()->first();
                }
            } else {
                $page = Page::where("slugs", $slugs)->orWhere("slugs", "/" . $slugs)->get()->first();
            }
        }

        $notFoundData = self::throwNotFound(false, $page);
        if(
            !is_null($notFoundData) &&
            $notFoundData->getStatusCode() == 404
        ) {
            return $notFoundData;
        }

        $page = Page::find($page->uid);
        $uid = $page->getAttribute("uid");

        $uniqid = preg_replace("/[^a-zA-Z0-9]+/", "", $host) . "-" . $page->uid;

        $renderedHTML = "";

        $customCacheCfg = false;
        $cachingConfig = config("centauri")["config"]["Caching"];
        $cacheState = $cachingConfig["state"];
        $cachingType = $cachingConfig["type"] ?? null;

        if($cacheState) {
            if($cachingType == "STATIC_FILE_CACHE") {
                if(StaticFileCache::hasCache($uniqid)) {
                    $renderedHTML = StaticFileCache::getCache($uniqid);
                    dd($renderedHTML);
                }
            } else {
                $customCacheCfg = true;
            }
        }

        if($cacheState && !$customCacheCfg) {
            if(Cache::has($uniqid)) {
                $renderedHTML = Cache::get($uniqid);
            }
        }

        if($renderedHTML != "") {
            $renderedHTML .= "\r\n<!-- End Cached Content -->";
            $page->cached_content = $renderedHTML;
        }

        if(isset($domainConfigJSON->pageTitlePrefix)) {
            $page->pageTitlePrefix = $domainConfigJSON->pageTitlePrefix;
        }

        // Overwrites of beLayouts (if custom layouts has been defined, this rendering can manage how the HTML-output looks like)
        $beLayout = config("centauri")["beLayouts"][$page->backend_layout] ?? null;
        $ElementComponent = Centauri::makeInstance(ElementComponent::class);

        if($renderedHTML != "") {
            $renderedHTML = "";

            if(!isset(config("centauri")["beLayouts"][$page->backend_layout]) || is_null($beLayout)) {
                if(Centauri::isLocal()) {
                    throw new Exception("The BE-Layout '" . $page->backend_layout . "' for this page has no configuration yet!");
                }
            }

            // Calling ElementComponent which renders the content elements by the given page-uid ($uid) or rendering if its overwritten
            if(!isset($beLayout["rendering"])) {
                $renderedHTML = $ElementComponent->render($uid, $page->lid, 0, 0);
            }
        } else {
            if(isset($beLayout["rendering"])) {
                $renderedHTML = Centauri::makeInstance($beLayout["rendering"])::rendering($page);
            }
        }

        $renderedHTML = str_replace("  ", "", $renderedHTML);
        $renderedHTML = str_replace("\r\n", "", $renderedHTML);

        $additionalHeadTagContent = FrontendRenderingHandler::getAdditonalHeadTagContent();
        $frontendHtml = FrontendRenderingHandler::getPreparedFrontendHtml($page, $renderedHTML, $additionalHeadTagContent);

        // Caching only if it's set in Centauri's config array (which gets by default cached from Laravel)
        if(isset(config("centauri")["config"]["Caching"]) && (config("centauri")["config"]["Caching"])) {
            // Caching before returning the outputted frontend html for 24 hours (86400 seconds)
            if($renderedHTML != "" && $cacheState) {
                if($customCacheCfg) {
                    if($cachingType == "STATIC_FILE_CACHE") {
                        StaticFileCache::setCache($uniqid, $renderedHTML);
                    }
                } else {
                    Cache::put($uniqid, $renderedHTML, 86400);
                }
            }
        }

        return $frontendHtml;
    }

    public static function throwNotFound($force = false, $page = null)
    {
        $throwNotFound = false;

        if(!$force && is_null($page)) {
            $throwNotFound = true;
        } else if($force) {
            $throwNotFound = true;
        }

        if($throwNotFound) {
            $class = Centauri::makeInstance($GLOBALS["Centauri"]["Handlers"]["pageNotFound"]);
            return $class::handle();
        }
    }
}
