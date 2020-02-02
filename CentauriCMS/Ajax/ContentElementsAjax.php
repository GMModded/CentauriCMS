<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Element;
use Centauri\CMS\Model\File;
use Centauri\CMS\Service\MinifyHTMLService;
use Exception;
use Illuminate\Support\Str;

class ContentElementsAjax implements AjaxInterface
{
    public $excludedFields = [
        "uid",
        "parent_uid",
        "pid",
        "lid",

        "rowPos",
        "colPos",
        "sorting",
        "ctype",

        "created_at",
        "updated_at",
        "deleted_at"
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
            $backendLayout = config("centauri")["beLayouts"][$page->getAttribute("backend_layout")] ?? null;

            if(is_null($backendLayout)) {
                return response("Backend-Layout '" . $page->getAttribute("backend_layout") . "' not found for page with ID: " . $page->getAttribute("uid"), 500);
            }

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
                $label = $field["label"];
                $type = $field["type"];

                // Config stuff
                $config = $field["config"] ?? [];
                $fieldConfiguration = $CCE["fieldConfiguration"][$ctype] ?? null;

                if(isset($field["config"])) {
                    foreach($field["config"] as $configKey => $configValue) {
                        $config[$configKey] = $configValue;
                    }
                }

                if(!is_null($fieldConfiguration)) {
                    if(isset($fieldConfiguration["label"])) {
                        $label = $fieldConfiguration["label"];
                    }

                    if(isset($fieldConfiguration["type"])) {
                        $type = $fieldConfiguration["type"];
                    }

                    if(isset($fieldConfiguration["config"])) {
                        if(!empty($fieldConfiguration["config"])) {
                            foreach($fieldConfiguration["config"] as $fieldConfigurationConfigItemKey => $fieldConfigurationConfigItemValue) {
                                $config[$fieldConfigurationConfigItemKey] = $fieldConfigurationConfigItemValue;
                            }
                        }
                    }
                }

                // additionalData stuff for "special fields"
                $additionalData = [];

                if($type == "plugin") {
                    $additionalData["plugins"] = $GLOBALS["Centauri"]["Plugins"];
                }

                // Model (Inline) Stuff
                if($type == "model") {
                    $modelFields = $config["fields"];

                    $modelWrapper = view("Centauri::Backend.Modals.newContentElement.Fields.model", [
                        "modelName" => $field["label"],
                        "modelIdName" => $ctype,
                        "view" => "new"
                    ])->render();

                    foreach($modelFields as $modelFieldName => $modelField) {
                        $modelLabel = $modelField["label"];
                        $modelType = $modelField["type"];

                        // Config stuff
                        $modelConfig = $modelField["config"] ?? [];

                        if($modelType == "plugin") {
                            throw new Exception("The Model-Type '" . $modelType . "' is not allowed here!");
                        }

                        $_html = view("Centauri::Backend.Modals.newContentElement.Fields." . $modelType, [
                            "id" => $modelFieldName,
                            "label" => $modelLabel,
                            "additionalData" => [],
                            "config" => $modelConfig
                        ])->render();

                        $modelWrapper = str_replace("###MODEL_CONTENT###", $_html, $modelWrapper);
                        $html = $modelWrapper;
                    }
                } else {
                    $html = view("Centauri::Backend.Modals.newContentElement.Fields." . $type, [
                        "id" => $ctype,
                        "label" => $label,
                        "additionalData" => $additionalData,
                        "config" => $config
                    ])->render();
                }

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
            $element->lid = $lid;
            $element->rowPos = $rowPos;
            $element->colPos = $colPos;
            $element->ctype = $ctype;
            $element->sorting = $sorting;

            $inlineFileRecords = [];
            $inlineRecords = [];

            foreach($datasArr as $dataObj) {
                $type = $dataObj["type"];
                $value = $dataObj["value"];

                $inline = $dataObj["inline"] ?? "";

                if($inline && $inline != "" && gettype($inline) == "string") {
                    $inlineParent = $inline;
                    
                    if(!isset($inlineRecords[$inlineParent])) {
                        $inlineRecords[$inlineParent] = [$dataObj];
                    } else {
                        $inlineRecords[$inlineParent][] = $dataObj;
                    }
                } else {
                    if($type == "NORMAL") {
                        $id = $dataObj["id"];
                        $element->setAttribute($id, $value);
                    }

                    if($type == "INLINE") {
                        $dataType = $dataObj["dataType"];
                        $uid = $value;
    
                        if(!isset($inlineFileRecords[$dataType])) {
                            $inlineFileRecords[$dataType] = "";
                        }
    
                        $inlineFileRecords[$dataType] .= $uid . ",";
                    }
                }
            }

            $CCEfields = config("centauri")["CCE"]["fields"];

            foreach($inlineRecords as $inline => $inlineFields) {
                $CCEfield = $CCEfields[$inline];

                $modelClass = $CCEfield["config"]["model"];
                $model = new $modelClass;

                foreach($inlineFields as $inlineField) {
                    $id = $inlineField["id"];
                    $value = $inlineField["value"];

                    $model->setAttribute($id, $value);
                }

                $model->save();
            }

            // Removing in case every last "," inside $inlineFileRecords[x]'s string (uidString - comma separated)
            foreach($inlineFileRecords as $dT => $uidStr) {
                if(mb_substr($uidStr, -1) == ",") {
                    $inlineFileRecords[$dT] = mb_substr($uidStr, 0, -1);
                }
            }

            foreach($inlineFileRecords as $dataType => $uidString) {
                $element->$dataType = $uidString;
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
                $renderHtmlByView = true;

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

                    $extraArr = [];

                    if($fieldType == "plugin") {
                        $pluginConfig = Centauri::makeInstance($fieldConfiguration["config"]["class"]);
                        $additionalData["plugin"] = $pluginConfig;
                    }

                    if($fieldType == "model") {
                        $renderHtmlByView = false;

                        $extraArr["modelIdName"] = $field;
                        $extraArr["modelName"] = $fieldConfiguration["newItemLabel"];

                        $modelFields = $fieldConfiguration["config"]["fields"];
                        $modelClass = $fieldConfiguration["config"]["model"];

                        $model = new $modelClass;
                        $models = $model::where("parent_uid", $uid)->get()->all();

                        $extraArr["models"] = $models;
                        $extraArr["uid"] = null;

                        $modelsHtmlWrapper = view("Centauri::Backend.Modals.newContentElement.Fields.model_control", [
                            "modelType" => $field,
                            "modelLabel" => $fieldConfiguration["label"],
                            // "modelCreateNewButtonName" => $fieldConfiguration["newItemLabel"],
                            "modelFieldKeyName" => $field,
                            "fieldConfiguration" => $fieldConfiguration
                        ])->render();

                        $modelsHtml = "";
                        $html = "";

                        foreach($models as $model) {
                            $modelsHtml .= view("Centauri::Backend.Modals.newContentElement.Fields.model_singleitem", [
                                "uid" => $model->uid
                            ])->render();

                            $attributes = $model->getAttributes();
                            $_bottom = "";

                            foreach($attributes as $attrName => $attrVal) {
                                if(!in_array($attrName, $this->excludedFields)) {
                                    $modelFieldConfig = $fieldConfiguration["config"]["fields"][$attrName] ?? null;

                                    if(is_null($modelFieldConfig)) {
                                        throw new Exception("Field $attrName can't be null!");
                                    }

                                    $_bottom .= view("Centauri::Backend.Modals.newContentElement.Fields." . $modelFieldConfig["type"], [
                                        "id" => $attrName . "-" . $model->uid,
                                        "label" => $modelFieldConfig["label"],
                                        "config" => $modelFieldConfig,
                                        "isInlineRecord" => 1,
                                        "value" => $attrVal
                                    ])->render();
                                }
                            }

                            if(Str::contains($fieldConfiguration["existingItemLabel"], "{") && Str::contains($fieldConfiguration["existingItemLabel"], "}")) {
                                $modelDynLabel = $fieldConfiguration["existingItemLabel"];
                                $modelDynLabel = str_replace("{", "", $modelDynLabel);
                                $modelDynLabel = str_replace("}", "", $modelDynLabel);

                                $modelsHtml = str_replace("###MODEL_CONTENT_TOP###", ($model->$modelDynLabel == "" ? "<i>" . $fieldConfiguration["newItemLabel"] . "</i>" : $model->$modelDynLabel), $modelsHtml);
                            } else {
                                $modelsHtml = str_replace("###MODEL_CONTENT_TOP###", $fieldConfiguration["existingItemLabel"], $modelsHtml);
                            }

                            $modelsHtml = str_replace("###MODEL_CONTENT_BOTTOM###", $_bottom, $modelsHtml);
                        }

                        $modelsHtml .= "</div>";
                        $modelsHtmlWrapper = str_replace("###MODEL_CONTENT###", $modelsHtml, $modelsHtmlWrapper);

                        $html .= $modelsHtmlWrapper;
                    }

                    $dataArr = [
                        "id" => $field,
                        "label" => $fieldConfiguration["label"],
                        "value" => $value,
                        "additionalData" => $additionalData,
                        "config" => $config
                    ];

                    if(!empty($extraArr)) {
                        foreach($extraArr as $exKey => $exVal) {
                            $dataArr[$exKey] = $exVal;
                        }
                    }

                    $html = ($renderHtmlByView ? view("Centauri::Backend.Modals.newContentElement.Fields.$fieldType", $dataArr)->render() : $html);
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

                $inlineFileRecords = [];
                $inlineRecords = [];

                foreach($datasArr as $dataObj) {
                    $uid = $dataObj["uid"] ?? dd($dataObj);
                    $element = Element::where("uid", $uid)->get()->first();

                    $type = $dataObj["type"];
                    $value = $dataObj["value"];

                    $inline = $dataObj["inline"] ?? "";

                    if($inline && $inline != "" && gettype($inline) == "string") {
                        $inlineParent = $inline;
                        $inlineRecords[$inlineParent][] = $dataObj;
                    } else {
                        if($type == "NORMAL") {
                            $id = explode("-", $dataObj["id"])[0];
                            $element->setAttribute($id, $value);
                        }

                        if($type == "INLINE") {
                            $dataType = $dataObj["dataType"];
                            $uid = $value;

                            if(!isset($inlineFileRecords[$dataType])) {
                                $inlineFileRecords[$dataType] = "";
                            }

                            $inlineFileRecords[$dataType] .= $uid . ",";
                        }
                    }
                }

                $CCEfields = config("centauri")["CCE"]["fields"];

                foreach($inlineRecords as $inline => $inlineFields) {
                    $CCEfield = $CCEfields[$inline];
                    $modelClass = $CCEfield["config"]["model"] ?? null;

                    foreach($inlineFields as $inlineField) {
                        $uid = $inlineField["uid"];
                        $model = null;

                        if(!is_null($modelClass)) {
                            $model = $modelClass::where("uid", $uid)->get()->first();
                        }

                        if(is_null($model)) {
                            $attributes = [];

                            $attributes["parent_uid"] = $element->uid ?? $inlineField["uid"];
    
                            foreach($inlineFields as $inlineField) {
                                $id = explode("-", $inlineField["id"])[0];
                                $value = $inlineField["value"];
    
                                $attributes[$id] = $value;
                            }
    
                            if(!is_null($modelClass)) {
                                $model = $modelClass::create($attributes);
                            }
                        } else {
                            $id = explode("-", $inlineField["id"])[0];
                            $value = $inlineField["value"];

                            $model->$id = $value;
                            $model->save();
                        }
                    }

                    // $size = count($inlineRecords[$inline]);
                    // $element->setAttribute($inline, $size);
                }

                // if($element->save()) {
                    return json_encode([
                        "type" => "success",
                        "title" => "Element saved",
                        "description" => "This element has been saved"
                    ]);
                // }
            }

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

        return AjaxAbstract::default($request, $ajaxName);
    }
}
