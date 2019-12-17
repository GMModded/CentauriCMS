<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\Element;

class ContentElementsAjax implements AjaxInterface
{
    public $excludedFields = [
        "uid",
        "pid",
        "lid",

        "rowPos",
        "colPos",
        "sorting",
        "ctype",

        "created_at",
        "updated_at"
    ];

    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "findByPid") {
            $uid = $request->input("pid");
            $lid = 0; // $request->input("lid");

            $elements = Element::where([
                "pid" => $uid,
                "lid" => $lid
            ])->orderBy("sorting", "asc")->get();

            $CCE = config("centauri")["CCE"];
            $fields = $CCE["fields"];

            foreach($elements as $element) {
                $uid = $element->uid;
                
                foreach($fields as $fieldName => $fieldArr) {
                    $type = $fieldArr["type"];
                    $label = $fieldArr["label"];

                    $attributes = $element->getAttributes();
                    foreach($attributes as $attrName => $attrVal) {
                        if(!in_array($attrName, $this->excludedFields)) {
                            if($fieldName == $attrName) {
                                $html = view("Backend.Modals.newContentElement.Fields." . $type, [
                                    "id" => $fieldName,
                                    "label" => $label,
                                    "value" => $attrVal
                                ])->render();

                                $fields[$fieldName]["_HTML"][$element->uid] = $html;
                                $CCE["fields"][$fieldName]["_HTML"][$element->uid] = $html;
                            }
                        }
                    }
                }
            }

            $page = \Centauri\CMS\Model\Page::where("uid", $uid)->get()->first();
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
            $pid = $request->input("pid");
            $lid = 0; // $request->input("lid");
            $rowPos = $request->input("rowPos");
            $colPos = $request->input("colPos");
            $ctype = $request->input("ctype");
            $insert = $request->input("insert");

            $element = null;
            $sorting = 0;

            if($insert == "before") {
                $sorting = $request->input("sorting");

                $elements = Element::where("sorting", ">=", $sorting)->get()->all();
                foreach($elements as $element) {
                    $eSorting = $element->sorting;

                    $eSorting++;
                    $element->sorting = $eSorting;
                    $element->save();
                }
            }

            if($insert == "after") {
                $element = Element::where([
                    "pid" => $pid,
                    "lid" => $lid,
                    "rowPos" => $rowPos,
                    "colPos" => $colPos
                ])->orderBy("sorting", "asc")->get()->last();

                if(!is_null($element)) {
                    $sorting = $element->sorting + 1;
                }
            }

            $datas = $request->input("datas");
            $datasArr = json_decode($datas, true);

            $element = new Element;
            $element->pid = $pid;
            $element->lid = 0;
            $element->rowPos = $rowPos;
            $element->colPos = $colPos;
            $element->ctype = $ctype;
            $element->sorting = $sorting;



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

        if($ajaxName == "findFieldsByUid") {
            $uid = $request->input("uid");
            $element = Element::where("uid", $uid)->get()->first();

            $CCE = config("centauri")["CCE"];
            $fields = $CCE["fields"];

            foreach($fields as $fieldName => $fieldArr) {
                $type = $fieldArr["type"];
                $label = $fieldArr["label"];

                $attributes = $element->getAttributes();
                foreach($attributes as $attrName => $attrVal) {
                    if(!in_array($attrName, $this->excludedFields)) {
                        if($fieldName == $attrName) {
                            $html = view("Backend.Modals.newContentElement.Fields." . $type, [
                                "id" => $fieldName,
                                "label" => $label,
                                "value" => $attrVal
                            ])->render();

                            $fields[$fieldName]["_HTML"][$element->uid] = $html;
                            $CCE["fields"][$fieldName]["_HTML"][$element->uid] = $html;
                        }
                    }
                }
            }

            return view("Backend.Partials.fieldForElement", [
                "element" => $element,

                "data" => [
                    "fields" => $fields
                ]
            ])->render();
        }

        if(
            $ajaxName == "saveElementByUid"
        ||
            $ajaxName == "hideElementByUid"
        ||
            $ajaxName == "deleteElementByUid"
        ) {
            $uid = $request->input("uid");
            $element = Element::where("uid", $uid)->get()->first();

            if($ajaxName == "saveElementByUid") {
                $datas = $request->input("datas");
                $datasArr = json_decode($datas, true);

                foreach($datasArr as $dataObj) {
                    $id = $dataObj["id"];
                    $value = $dataObj["value"];

                    $element->setAttribute($id, $value);
                }

                $element->save();
            }

            if($ajaxName == "hideElementByUid") {
                $element->hidden = !$element->hidden;
                $element->save();
            }

            if($ajaxName == "deleteElementByUid") {
                $element->delete();
            }
        }
    }
}
