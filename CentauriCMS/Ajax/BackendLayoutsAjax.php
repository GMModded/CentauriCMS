<?php
namespace Centauri\CMS\Ajax;

use \Illuminate\Http\Request;
use Centauri\CMS\Traits\AjaxTrait;

class BackendLayoutsAjax
{
    use AjaxTrait;

    /**
     * Finds all Backend-Layouts and returns them when e.g. creating a new page or editing a specific be-layout.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findAllAjax(Request $request)
    {
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
