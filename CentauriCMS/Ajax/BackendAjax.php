<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;

class BackendAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "login") {
            $username = $request->input("username");
            $password = $request->input("password");

            if($username == "admin" && $password == "password") {
                $request->session()->put("CENTAURI_BE_USER", true);

                return json_encode([
                    "type" => "success",
                    "title" => "Welcome back, $username",
                    "description" => "Enjoy your session!",

                    "headtags" => [
                        ["title", "Centauri"]
                    ]
                ]);
            }

            return json_encode([
                "type" => "error",
                "title" => "Login failed",
                "description" => "Username/password is wrong!"
            ]);
        }

        if($ajaxName == "getBackendLayout") {
            $pid = $request->input("pid");

            $page = \Centauri\CMS\Model\Page::find($pid);
            $backendLayout = \Centauri\CMS\Model\BackendLayout::find($page->getAttribute("backend_layout"));

            // $backendLayoutData = json_decode($backendLayout->getAttribute("data"));
            return $backendLayout->getAttribute("data");
        }
    }
}
