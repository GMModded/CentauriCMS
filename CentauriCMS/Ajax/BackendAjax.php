<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\Model\BeUser;
use Centauri\CMS\Traits\AjaxTrait;

/**
 * Backend Ajax class - handles login and Backend-specific settings for an User or similiar actions/stuff.
 */
class BackendAjax
{
    use AjaxTrait;

    /**
     * Login-Ajax method called by request-method above.
     * Handles valid Backend-User logins and logs failed logins.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function loginAjax(Request $request)
    {
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
            $request->session()->put("CENTAURI_BE_USER", $user);

            // $Centauri->initBE();
            $localizedArr = \Centauri\CMS\Service\Locales2JSService::getLocalizedArray();

            $html = view("Centauri::Backend.centauri", [
                "data" => [
                    "modules" => $GLOBALS["Centauri"]["Modules"],
                    "localizedArr" => $localizedArr,
                    "dashboard" => $_GET["dashboard"] ?? "1",
                    "beuser" => $user,
                    "loadedBy" => "LOGIN_AJAX"
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
}
