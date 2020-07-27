<?php
namespace Centauri\Extension\Frontend\Http;

use Centauri\CMS\Centauri;
use Centauri\Extension\Frontend\Frontend;

class Routes extends Frontend
{
    public function __construct()
    {
        $GLOBALS["Centauri"]["Handlers"]["routes"][
            $this->getExtensionKey()
        ][] = [
            function() {
                \Illuminate\Support\Facades\Route::any("/frontend/login", function() {
                    return redirect("/");

                    $loggedIn = Centauri::FrontendUser()->loggedIn();

                    /** Means the user is trying to log in if empty. */
                    if(!empty(request()->input())) {
                        $params = request()->input();

                        $username = $params["username"];
                        $password = $params["password"];
                    }

                    return view("centauri_frontend::Frontend.Routes.login", [
                        "loggedIn" => $loggedIn
                    ])->render();
                });
            }
        ];
    }
}
