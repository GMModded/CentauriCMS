<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Abstracts\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\BeUser;
use Centauri\CMS\Service\SchedulerService;

class BackendAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "login") {
            if(is_null(session()->get("CENTAURI_BE_LANGUAGE"))) {
                session()->put("CENTAURI_BE_LANGUAGE", 1);
            }

            $username = $request->input("username");
            $password = $request->input("password");

            $user = BeUser::where([
                "username" => $username,
                "password" => $password
            ])->get()->first();

            if(!is_null($user)) {
                $request->session()->put("CENTAURI_BE_USER", true);

                // $Centauri->initBE();
                $localizedArr = \Centauri\CMS\Service\Locales2JSService::getLocalizedArray();

                $html = view("Centauri::Backend.centauri", [
                    "data" => [
                        "modules" => $GLOBALS["Centauri"]["Modules"],
                        "localizedArr" => $localizedArr,
                        "dashboard" => $_GET["dashboard"] ?? "1"
                    ]
                ])->render();

                $explodedHtml = explode("\n", $html);
                
                foreach($explodedHtml as $key => $value) {
                    if(\Str::contains($value, "<script ")) {
                        unset($explodedHtml[$key]);
                    }
                }

                $html = implode("\n", $explodedHtml);

                return json_encode([
                    "type" => "success",
                    "title" => "Welcome back, $username",
                    "description" => "Enjoy your session!",

                    "headtags" => [
                        ["title", "CentauriCMS"]
                    ],

                    "html" => $html
                ]);
            }

            return response("Username/Password is wrong!", 500);
        }

        if($ajaxName == "getBackendLayout") {
            $pid = $request->input("pid");

            $page = \Centauri\CMS\Model\Page::find($pid);
            return null;
            // $backendLayout = \Centauri\CMS\Model\BackendLayout::find($page->getAttribute("backend_layout"));

            // $backendLayoutData = json_decode($backendLayout->getAttribute("data"));
            // return $backendLayout->getAttribute("data");
        }

        if($ajaxName == "triggerscheduler") {
            return SchedulerService::run("test_scheduler");
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
