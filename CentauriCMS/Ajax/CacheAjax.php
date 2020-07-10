<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Centauri\CMS\Caches\StaticFileCache;
use Centauri\CMS\Traits\AjaxTrait;

class CacheAjax
{
    use AjaxTrait;

    /**
     * Flushes the cache for the frontend of this application.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function flushFrontendAjax(Request $request)
    {
        Artisan::call("cache:clear");
        Artisan::call("view:clear");

        Cache::flush();
        StaticFileCache::deleteAll();

        return json_encode([
            "type" => "primary",
            "title" => "Cache - Frontend",
            "description" => "Cache has been successfully flushed!"
        ]);
    }

    /**
     * Flushes the cache for the backend of this application.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function flushBackendAjax(Request $request)
    {
        Artisan::call("cache:clear");
        Artisan::call("config:clear");
        Artisan::call("config:cache");

        return json_encode([
            "type" => "primary",
            "title" => "Cache - Backend",
            "description" => "Cache has been successfully flushed!"
        ]);
    }

    /**
     * Flushes the cache for both, the frontend and backend, of this application.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function flushAllAjax(Request $request)
    {
        Artisan::call("cache:clear");
        Artisan::call("config:clear");
        Artisan::call("view:clear");
        Artisan::call("config:cache");

        Cache::flush();
        StaticFileCache::deleteAll();

        return json_encode([
            "type" => "primary",
            "title" => "Cache - System",
            "description" => "Cache has been successfully flushed for the entire system!"
        ]);
    }
}
