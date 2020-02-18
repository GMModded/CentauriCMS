<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;

class CacheAjax extends AjaxAbstract implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "flushFrontend") {
            \Artisan::call("cache:clear");
            \Artisan::call("view:clear");

            return json_encode([
                "type" => "success",
                "title" => "Cache - Frontend",
                "description" => "Cache has been successfully flushed!"
            ]);
        }

        if($ajaxName == "flushBackend") {
            \Artisan::call("cache:clear");
            \Artisan::call("config:clear");
            \Artisan::call("config:cache");

            return json_encode([
                "type" => "success",
                "title" => "Cache - Backend",
                "description" => "Cache has been successfully flushed!"
            ]);
        }

        if($ajaxName == "flushAll") {
            \Artisan::call("cache:clear");
            \Artisan::call("config:clear");
            \Artisan::call("view:clear");
            \Artisan::call("config:cache");

            \Cache::flush();

            return json_encode([
                "type" => "success",
                "title" => "Cache - System",
                "description" => "Cache has been successfully flushed for the entire system!"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
