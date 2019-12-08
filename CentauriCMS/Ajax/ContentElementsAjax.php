<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;

class ContentElementsAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "findByPid") {
            $pid = $request->input("pid");
            $lid = 0; // $request->input("lid");

            $elements = \Centauri\CMS\Model\Element::where([
                "pid" => $pid,
                "lid" => $lid
            ])->get();

            foreach($elements as $element) {
                $element->data = json_decode($element->getAttribute("data"));
            }

            return json_encode([
                "elements" => $elements
            ]);
        }
    }
}
