<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\Element;

class ContentElementsAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "findByPid") {
            $pid = 0; // $request->input("pid");
            $lid = 0; // $request->input("lid");

            $elements = \Centauri\CMS\Model\Element::where([
                "pid" => $pid,
                "lid" => $lid
            ])->get();

            $CCE = config("centauri")["CCE"];

            $fields = $CCE["fields"];

            foreach($fields as $ctype => $field) {
                $type = $field["type"];
                $label = $field["label"];

                $html = view("Backend.Modals.newContentElement.Fields." . $type, [
                    "id" => $ctype,
                    "label" => $label,
                    "value" => "jesus"
                ])->render();

                $fields[$ctype]["_HTML"] = $html;
                $CCE["fields"][$ctype]["_HTML"] = $html;
            }

            $page = \Centauri\CMS\Model\Page::where("pid", $pid)->get()->first();
            $backendLayout = config("centauri")["beLayouts"]["default"]; // \Centauri\CMS\Model\BackendLayout::find($page->getAttribute("backend_layout"));

            return view("Backend.Partials.elements", [
                "data" => [
                    "beLayout" => $backendLayout,
                    "elements" => $elements->all(),
                    "fields" => $fields
                ]
            ])->render();
        }

        if($ajaxName == "getConfigCCE") {
            $CCE = config("centauri")["CCE"];

            $fields = $CCE["fields"];

            foreach($fields as $ctype => $field) {
                $type = $field["type"];
                $label = $field["label"];

                $html = view("Backend.Modals.newContentElement.Fields." . $type, [
                    "id" => $ctype,
                    "label" => $label
                ])->render();

                $fields[$ctype]["_HTML"] = $html;
                $CCE["fields"][$ctype]["_HTML"] = $html;
            }

            return view("Backend.Modals.newContentElement", [
                "CCE" => $CCE
            ])->render();
        }

        if($ajaxName == "newElement") {
            $datas = $request->input("datas");
            $ctype = $request->input("ctype");

            $datasArr = json_decode($datas, true);

            $element = new Element;
            $element->rowPos = 1;
            $element->colPos = 2;
            $element->ctype = $ctype;

            foreach($datasArr as $dataObj) {
                $id = $dataObj["id"];
                $value = $dataObj["value"];

                $element->setAttribute($id, $value);
            }

            $element->save();

            return json_encode([
                "type" => "success",
                "title" => "Element created",
                "description" => "This element has been created"
            ]);
        }
    }
}
