<?php
namespace Centauri\CMS\CentauriServer;

use Centauri\CMS\Caches\StaticFileCache;
use Centauri\CMS\Centauri;
use Centauri\CMS\CentauriServer;
use Centauri\CMS\Utility\PathUtility;
use Centauri\CMS\Utility\SeoUrlUtility;
use \Illuminate\Support\Str;

/**
 * The KernelLevelCaching class is to set and retrieve the current requested URI's response's content (HTML code) into a static file.
 * An alternative to StaticFileCaching - which first runs through Laravel's Request::capture()-method (which needs some time) and then actually caches and retrieves.
 * KernelCaching actually skips the part with running through Laravel's Request::capture()-method to simply avoid unnecessary method calls and for a faster page-speed.
 */
class KernelLevelCaching extends CentauriServer
{
    /**
     * Calling the parent in case config-property is set before actually using it in this class itself.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * This method handles if there's a cached version of the requested URL.
     * 
     * @return bool
     */
    public function handle()
    {
        if(!$this->cachableRequestUri()) {
            $requestedUri = PathUtility::getRequestedURL();
            $hooks = Centauri::getHookByKey("Cache")["KernelStaticFileCache"]["getCache"];

            if($requestedUri == "/") {
                $requestedUri = SeoUrlUtility::slugify($_SERVER["HTTP_HOST"], "");
            }

            if(!empty($_POST)) {
                $requestedUri = $requestedUri . "_content";
            }

            $staticFileCached = StaticFileCache::getCacheKernel($requestedUri);

            foreach($hooks ?? [] as $hook) {
                $staticFileCached = Centauri::makeInstance($hook, [
                    "cachedFilename" => $requestedUri,
                    "data" => $staticFileCached
                ])->__construct([
                    "cachedFilename" => $requestedUri,
                    "data" => $staticFileCached
                ]);
            }

            if(is_array($staticFileCached)) {
                $staticFileCached = StaticFileCache::getCacheKernel($staticFileCached["cachedFilename"]);
            }

            if(!empty($_POST)) {
                $cachedFilename = $staticFileCached["cachedFilename"] ?? null;

                if(!is_null($cachedFilename)) {
                    if($cachedFilename[0] == "/") {
                        $cachedFilename = preg_replace("/^\//", "", $cachedFilename);
                        $staticFileCached["cachedFilename"] = $cachedFilename;
                    }
                }
            }

            if($staticFileCached !== false) {
                if(is_array($staticFileCached)) {
                    echo $staticFileCached["data"];
                } else {
                    echo $staticFileCached;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * This method returns whether the requested URL (getable via PathUtility-class) is cachable (e.g. the .html-file exists) or not.
     * 
     * @return bool
     */
    public function cachableRequestUri()
    {
        $requestedUri = PathUtility::getRequestedURL();
        $kernelCachingCfg = $this->getConfig("KERNEL_LEVEL_CACHING");

        $filteredSlugs = $kernelCachingCfg->filteredSlugs;
        $filteredDetected = null;

        foreach($filteredSlugs as $slug) {
            if(Str::startsWith($requestedUri, $slug)) {
                $filteredDetected = $slug;
            }
        }

        if(!is_null($filteredDetected)) {
            if(isset($kernelCachingCfg->callback)) {
                $callbackInstance = Centauri::makeInstance($kernelCachingCfg->callback);
                $callbackInstance->callback($requestedUri, $slug);
            }
        }

        return (is_null($filteredDetected) ? false : true);
    }
}
