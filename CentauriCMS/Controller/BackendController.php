<?php
namespace Centauri\CMS\Controller;

use Illuminate\Http\Request;

class BackendController
{
    public function logoutAction(Request $request)
    {
        $request->session()->remove("CENTAURI_BE_USER");
        return redirect("/centauri");
    }
}
