<?php
namespace Centauri\Extension\Frontend;

use Centauri\CMS\Abstracts\ExtensionAbstract;
use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Interfaces\ExtensionInterface;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\CMS\Service\BodyAdditionalDataService;
use Centauri\CMS\Service\HeadAdditionalDataService;
use Centauri\Extension\Cookie\Models\ParentCookieModel;
use Centauri\Extension\Frontend\Elements\Elements;
use Centauri\Extension\Frontend\Hook\KernelStaticFileCacheGetCacheHook;
use Centauri\Extension\Frontend\Hook\KernelStaticFileCacheSetCacheHook;
use Centauri\Extension\Frontend\Http\Routes;

class Frontend extends ExtensionAbstract implements ExtensionInterface
{
    /**
     * Initialization of this Extension's main class.
     *
     * @return void
     */
    public function init()
    {
        $this->setExtensionKey("centauri_frontend");

        /** Registration of additional head- and body-tags for CSS- and JS-file. */
        HeadAdditionalDataService::add("centauri_frontend", \Centauri\Extension\Frontend\AdditionalDatas\HeadTagAdditionalDatas::class);
        BodyAdditionalDataService::add("centauri_frontend", \Centauri\Extension\Frontend\AdditionalDatas\BodyTagAdditionalDatas::class);

        /** Register of all Frontend Elements. */
        Centauri::makeInstance(Elements::class);

        /** Register of Configuration-Array for $GLOBALS["Centauri"]["Extensions"][$this->extensionKey]. */
        $GLOBALS["Centauri"]["Extensions"][$this->getExtensionKey()] = $this->getConfig();

        /** Register of custom pageNotFound Handler. */
        $GLOBALS["Centauri"]["Handlers"]["pageNotFound"] = \Centauri\Extension\Frontend\Http\PageNotFound::class;

        /** Views registration for this extension. */
        ViewResolver::register($this->getExtensionKey(), "EXT:" . $this->getExtensionKey() . "/Views");

        /** Custom route logic for frontend login. */
        Centauri::makeInstance(Routes::class);
    }

    /**
     * Returns the configuration for this array for the $GLOBALS-array
     * 
     * @return array
     */
    public function getConfig()
    {
        // $pusherConfig = config("broadcasting")["connections"]["pusher"];

        return [
            "config" => [
                "Elements" => [
                    "ViewNamespace" => [
                        "headerdescription" => "centauri_frontend::Frontend.Templates.Elements",
                        "headerimage" => "centauri_frontend::Frontend.Templates.Elements",
                        "slider" => "centauri_frontend::Frontend.Templates.Elements",
                        "boxitems" => "centauri_frontend::Frontend.Templates.Elements",
                        "titleteaser" => "centauri_frontend::Frontend.Templates.Elements"
                    ]
                ]
            ]
        ];
    }

    /**
     * Static function defined in /config/centauri.php -> ["beLayouts"]["default"]["rendering"]
     * 
     * @param \Centauri\CMS\Model\Page $page
     * @return void
     */
    public static function rendering($page)
    {
        $uid = $page->uid;
        $lid = $page->lid;

        $ElementComponent = Centauri::makeInstance(ElementComponent::class);

        /** @var object */
        $domain = $page->getDomain();
        $id = "Main";

        if(!is_null($domain)) {
            $id = $domain->id;
        }

        $contentColHTML = $ElementComponent->render($uid, $lid, 0, 0);

        $template = "frontend";

        if($id == "Docs") {
            $template = "docs";
        }

        $cookies = ParentCookieModel::get()->all();

        return view("centauri_frontend::Frontend.Layouts." . $template, [
            "domain" => $domain,
            "contentColHTML" => $contentColHTML,
            "cookies" => $cookies
        ])->render();
    }

    public function kernelRegistrationLoader()
    {
        /** Registration of Hooks for KernelStaticFileCache (Set-/GetCache) */
        $GLOBALS["Centauri"]["Hooks"]["Cache"]["KernelStaticFileCache"]["setCache"]["centauri_frontend"] = KernelStaticFileCacheSetCacheHook::class;
        $GLOBALS["Centauri"]["Hooks"]["Cache"]["KernelStaticFileCache"]["getCache"]["centauri_frontend"] = KernelStaticFileCacheGetCacheHook::class;
    }
}
