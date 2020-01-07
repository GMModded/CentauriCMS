<?php
namespace Centauri\CMS\Controller;

use Centauri\CMS\Centauri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BackendController
{
    public function logoutAction(Request $request)
    {
        $request->session()->remove("CENTAURI_BE_USER");
        return redirect("/centauri");
    }

    public function languageAction(Request $request)
    {
        $URLParamsHelper = Centauri::makeInstance(\Centauri\CMS\Helper\ControllerURLParamsHelper::class, "Backend");
        $language = $URLParamsHelper->getParam("language");

        $request->session()->put("CENTAURI_LANGUAGE", $language);

        App::setLocale($language);

        return redirect()->back();
    }
}
