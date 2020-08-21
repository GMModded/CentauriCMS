<?php
namespace Centauri\Extension\Frontend\Hook;

use Centauri\CMS\Caches\StaticFileCache;

class KernelStaticFileCacheGetCacheHook
{
    public function __construct($params)
    {
        $cachedFilename = $params["cachedFilename"];
        $data = $params["data"];

        if(!empty($_POST)) {
            $cachedFilename = $cachedFilename . "_content";
            $contentData = StaticFileCache::getCacheKernel($cachedFilename);

            if(!$contentData) {
                $data = $contentData;
            }
        }

        return [
            "data" => $data,
            "cachedFilename" => $cachedFilename
        ];
    }
}
