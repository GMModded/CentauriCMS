<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Element;
use Centauri\CMS\Model\File;
use Exception;
use Illuminate\Support\Str;

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

            $page = \Centauri\CMS\Model\Page::where("uid", $uid)->get()->first();
            $backendLayout = config("centauri")["beLayouts"]["default"]; // \Centauri\CMS\Model\BackendLayout::find($page->getAttribute("backend_layout"));

            return view("Centauri::Backend.Partials.elements", [
                "data" => [
                    "beLayout" => $backendLayout,
                    "elements" => $elements->all(),
                    "fields" => $fields
                ]
            ])->render();
        }

        if($ajaxName == "getConfigCCE") {
            $ExtContentElements = $GLOBALS["Centauri"]["ContentElements"];
            $GLOBALS["Centauri"]["ContentElements"] = config("centauri")["CCE"];

            foreach($ExtContentElements as $key => $extCE) {
                $order = isset($extCE["order"]) ? $extCE["order"] : "default";

                if(isset($extCE["tabs"]) && !empty($extCE["tabs"])) {
                    $arr = array_merge($GLOBALS["Centauri"]["ContentElements"]["tabs"], $extCE["tabs"]);

                    if($order == "FIRST") {
                        $arr = array_merge($extCE["tabs"], $GLOBALS["Centauri"]["ContentElements"]["tabs"]);
                    }

                    $GLOBALS["Centauri"]["ContentElements"]["tabs"] = $arr;
                }

                if(isset($extCE["fields"]) && !empty($extCE["fields"])) {
                    $arr = array_merge($GLOBALS["Centauri"]["ContentElements"]["elements"], $extCE["fields"]);

                    if($order == "FIRST") {
                        $arr = array_merge($extCE["fields"], $GLOBALS["Centauri"]["ContentElements"]["fields"]);
                    }

                    $GLOBALS["Centauri"]["ContentElements"]["fields"] = $arr;
                }

                if(isset($extCE["elements"]) && !empty($extCE["elements"])) {
                    $arr = array_merge($GLOBALS["Centauri"]["ContentElements"]["elements"], $extCE["elements"]);

                    if($order == "FIRST") {
                        $arr = array_merge($extCE["elements"], $GLOBALS["Centauri"]["ContentElements"]["elements"]);
                    }

                    $GLOBALS["Centauri"]["ContentElements"]["elements"] = $arr;
                }
            }

            $CCE = $GLOBALS["Centauri"]["ContentElements"];
            $fields = $CCE["fields"];

            foreach($fields as $ctype => $field) {
                $type = $field["type"];
                $label = $field["label"];
                $additionalData = [];
                $config = [];

                if(isset($field["config"])) $config = $field["config"];

                if($type == "plugin") {
                    $additionalData["plugins"] = $GLOBALS["Centauri"]["Plugins"];
                }

                $html = view("Centauri::Backend.Modals.newContentElement.Fields." . $type, [
                    "id" => $ctype,
                    "label" => $label,
                    "additionalData" => $additionalData,
                    "config" => $config,
                ])->render();

                $fields[$ctype]["_HTML"] = $html;
                $CCE["fields"][$ctype]["_HTML"] = $html;
            }

            return view("Centauri::Backend.Modals.newContentElement", [
                "CCE" => $CCE
            ])->render();
        }

        if($ajaxName == "newElement") {
            $pid = $request->input("pid");
            $lid = 0; // $request->input("lid");
            $rowPos = $request->input("rowPos") ?? 0;
            $colPos = $request->input("colPos") ?? 0;
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
            $ctype = $element->ctype;

            $CCE = config("centauri")["CCE"];
            $elements = $CCE["elements"];

            $elementShowsFields = $elements[$ctype];

            $__html = "";
            foreach($elementShowsFields as $field) {
                $_html = "";

                if(Str::contains($field, ";")) {
                    $splittedFields = explode(";", $field);

                    foreach($splittedFields as $splittedField) {
                        $fieldConfiguration = $CCE["fields"][$splittedField];
                        $fieldType = $fieldConfiguration["type"];
                        $value = $element->$splittedField;
                        $additionalData = [];
                        $config = [];

                        if(isset($fieldConfiguration["config"])) $config = $fieldConfiguration["config"];

                        if($fieldType == "plugin") {
                            $additionalData["plugins"] = $GLOBALS["Centauri"]["Plugins"];
                        }

                        $html = "<div class='col'>" . view("Centauri::Backend.Modals.newContentElement.Fields.$fieldType", [
                            "id" => $splittedField,
                            "label" => $fieldConfiguration["label"],
                            "value" => $value,
                            "additionalData" => $additionalData,
                            "config" => $config
                        ])->render() . "</div>";

                        $_html .= $html;
                    }

                    $_html = "<div class='d-flex'>" . $_html . "</div>";
                } else {
                    $fieldConfiguration = $CCE["fields"][$field];
                    $fieldType = $fieldConfiguration["type"];
                    $value = $element->$field;
                    $additionalData = [];
                    $config = [];

                    if(isset($fieldConfiguration["config"])) $config = $fieldConfiguration["config"];

                    if($fieldType == "plugin") {
                        $pluginConfig = Centauri::makeInstance($fieldConfiguration["config"]["class"]);
                        $additionalData["plugin"] = $pluginConfig;
                    }

                    $html = "<div class='col'>" . view("Centauri::Backend.Modals.newContentElement.Fields.$fieldType", [
                        "id" => $field,
                        "label" => $fieldConfiguration["label"],
                        "value" => $value,
                        "additionalData" => $additionalData,
                        "config" => $config
                    ])->render() . "</div>";

                    $_html .= $html;
                }

                $__html .= $_html;
            }

            return view("Centauri::Backend.Partials.fieldForElement", [
                "element" => $element,

                "data" => [
                    "_HTML" => $__html
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
                    $type = $dataObj["type"];

                    if($type == "INLINE") {
                        $dataType = $dataObj["dataType"];
                        dd($dataObj);
                    }

                    if($type == "NORMAL") {
                        $id = $dataObj["id"];
                        $value = $dataObj["value"];

                        $element->setAttribute($id, $value);
                    }
                }

                if($element->save()) {
                    return json_encode([
                        "type" => "success",
                        "title" => "Element saved",
                        "description" => "This element has been saved"
                    ]);
                }
            }

            dd();

            if($ajaxName == "hideElementByUid") {
                $state = ($element->hidden ? "hidden" : "visible");

                $element->hidden = !$element->hidden;

                if($element->save()) {
                    return json_encode([
                        "type" => "primary",
                        "title" => "Element updated",
                        "description" => "This element is now " . $state
                    ]);
                }
            }

            if($ajaxName == "deleteElementByUid") {
                if(!is_null($element) && ($element->delete())) {
                    return json_encode([
                        "type" => "success",
                        "title" => "Element deleted",
                        "description" => "This element has been deleted"
                    ]);
                }
            }

            return response("ContentElements - was not able to update this element, please refresh the backend!", 500);
        }

        if($ajaxName == "saveImageToElementByUid") {
            $uid = $request->input("uid");
            $field = $request->input("field");
            $stringUids = $request->input("stringUids");

            $element = Element::where("uid", $uid)->get()->first();
            $element->$field = $stringUids;
            $element->save();
        }
    }
}
