<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use \Illuminate\Http\Request;
use Centauri\CMS\Interfaces\AjaxInterface;

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

        return AjaxAbstract::default($request, $ajaxName);
    }
}
