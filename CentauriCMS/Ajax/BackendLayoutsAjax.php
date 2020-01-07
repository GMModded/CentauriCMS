<?php
namespace Centauri\CMS\Ajax;

use \Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;

class BackendLayoutsAjax implements AjaxInterface
{
    public function request(Request $request, string $ajaxName)
    {
        if($ajaxName == "findAll") {
            $beLayouts = config("centauri")["beLayouts"];
            $layouts = [];

            foreach($beLayouts as $key => $beLayout) {
                $layouts[] = [
                    "name" => trans($beLayout["label"]),
                    "value" => lcfirst($key)
                ];
            }

            return json_encode($layouts);
        }
    }
}
