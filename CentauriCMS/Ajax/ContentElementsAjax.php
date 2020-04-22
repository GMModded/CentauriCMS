<?php
namespace Centauri\CMS\Ajax;

use Exception;
use Centauri\CMS\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Helper\ContentElementBEHelper;
use Centauri\CMS\Model\Element;
use Illuminate\Support\Str;
use Symfony\Component\Debug\Exception\FatalThrowableError;

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

    public function renderHtmlByField($fieldConfig, $data, $parent = "")
    {
        $html = "";

        foreach($data as $key => $value) {
            $fieldConfig[$key] = $value;
        }

        if($fieldConfig["type"] == "model") {
            $modelWrapper = view("Centauri::Backend.Modals.NewContentElement.Fields.model_control", [
                "modelType" => $data["id"],
                "modelTypeParent" => ($parent != "" ? $parent : $data["id"]),
                "modelLabel" => $fieldConfig["label"],
                "modelCreateNewButtonName" => $fieldConfig["newItemLabel"] ?? null,
                "modelParentUid" => $data["uid"]
            ])->render();

            $modelsHtml = "";

            $modelNamespace = $fieldConfig["config"]["model"];
            $parentUid = $fieldConfig["config"]["parent_uid"] ?? "parent_uid";
            $models = $modelNamespace::where($parentUid, $data["uid"])->orderBy("sorting", "asc")->get()->all();

            foreach($models as $model) {
                $_modelsHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
                    "uid" => $model->uid,
                    "sorting" => $model->sorting
                ])->render();

                $existingItemLabel = $fieldConfig["existingItemLabel"];
                $top = $model->$existingItemLabel ?? $fieldConfig["newItemLabel"] ?? "Item";

                $bottom = "";
                foreach($fieldConfig["config"]["fields"] as $_key => $_field) {
                    $bottom .= $this->renderField((is_int($_key) ? $_field : $_key), $model, $fieldConfig["id"]);
                }

                $_modelsHtml = str_replace("###MODEL_CONTENT_TOP###", $top, $_modelsHtml);
                $_modelsHtml = str_replace("###MODEL_CONTENT_BOTTOM###", $bottom, $_modelsHtml);

                $modelsHtml .= $_modelsHtml;
            }

            $html = str_replace("###MODEL_CONTENT###", $modelsHtml, $modelWrapper);
        } else {
            if(isset($fieldConfig["additionalType"])) {
                $additionalType = $fieldConfig["additionalType"];

                $html = view("Centauri::Backend.Modals.NewContentElement.Fields.AdditionalTypes." . $additionalType, [
                    "fieldConfig" => $fieldConfig
                ])->render();
            } else {
                $html = view("Centauri::Backend.Modals.NewContentElement.Fields." . $fieldConfig["type"], [
                    "fieldConfig" => $fieldConfig
                ])->render();
            }
        }

        return $html;
    }

    public function renderField($field, $element, $parent = "")
    {
        $html = "";
        $splittedFields = [];

        $CCE = config("centauri")["CCE"];
        $CCEfields = $CCE["fields"];

        if(Str::contains($field, ";")) {
            $splittedFields = explode(";", $field);
        }

        if(!empty($splittedFields)) {
            foreach($splittedFields as $_key => $_field) {
                if(!isset($CCEfields[$_field]) && !isset($CCEfields[$parent]["config"]["fields"][$_field])) {
                    $msg = "CCE - The configuration for field '" . $field . "' could not be found.";

                    if($parent != "") {
                        $msg = "CCE - The configuration for child-field '" . $field . "' of parent '" . $parent . "' could not be found.";
                    }

                    throw new Exception($msg);
                }

                if($parent != "") {
                    $fieldConfig = $CCEfields[$parent]["config"]["fields"][$_field];
                } else {
                    $fieldConfig = $CCEfields[$_field];
                }

                $html .= "<div class='col'>" . $this->renderHtmlByField($fieldConfig, [
                    "id" => $_field,
                    "value" => $element->$_field ?? "",
                    "uid" => $element->uid
                ], $parent) . "</div>";
            }

            $html = "<div class='row'>" . $html . "</div>";
        } else {
            if(!isset($CCEfields[$field]) && !isset($CCEfields[$parent]["config"]["fields"][$field])) {
                $msg = "CCE - The configuration for field '" . $field . "' could not be found.";

                if($parent != "") {
                    $msg = "CCE - The configuration for child-field '" . $field . "' of parent '" . $parent . "' could not be found.";
                }

                throw new Exception($msg);
            }

            if($parent != "") {
                $fieldConfig = $CCEfields[$parent]["config"]["fields"][$field];
            } else {
                $fieldConfig = $CCEfields[$field];
            }

            $html .= $this->renderHtmlByField($fieldConfig, [
                "id" => $field,
                "value" => $element->$field ?? "",
                "uid" => $element->uid,
                "isInlineRecord" => ($parent != "")
            ], $parent);
        }

        return $html;
    }

    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "findByPid") {
            $uid = $request->input("pid");
            $lid = $request->input("lid") ?? 0;

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
                $isModel = false;

                $type = $field["type"] ?? (isset($field["config"]["fields"]) ?? $isModel = true);

                // Config stuff
                $config = $field["config"] ?? [];
                $fieldConfiguration = $CCE["fieldConfiguration"][$ctype] ?? null;

                if(isset($field["config"])) {
                    foreach($field["config"] as $configKey => $configValue) {
                        $config[$configKey] = $configValue;
                    }
                }

                /**
                 * Overwrites of $field by $fieldConfiguration
                 * 
                 * @todo ?
                 */
                if(!is_null($fieldConfiguration) && !$isModel) {
                    if(isset($fieldConfiguration["label"])) {
                        $field["label"] = $fieldConfiguration["label"];
                    }

                    if(isset($fieldConfiguration["type"])) {
                        $type = $fieldConfiguration["type"];
                    }

                    if(isset($fieldConfiguration["config"])) {
                        if(!empty($fieldConfiguration["config"])) {
                            foreach($fieldConfiguration["config"] as $fieldConfigurationConfigItemKey => $fieldConfigurationConfigItemValue) {
                                $field["config"][$fieldConfigurationConfigItemKey] = $fieldConfigurationConfigItemValue;
                            }
                        }
                    }
                }

                // additionalData stuff for "special/custom fields"
                $additionalData = [];

                if(isset($GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$type])) {
                    $additionalDataClassName = $GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$type];
                    $additionalDataClass = Centauri::makeInstance($additionalDataClassName);

                    if(!method_exists($additionalDataClass, "fetch")) {
                        throw new Exception("Could not find 'fetch'-method in AdditionalData class of '" . $additionalDataClassName . "'!");
                    }

                    $additionalData = $additionalDataClass->fetch();
                }

                if(!$isModel) {
                    // Model (Inline) Stuff
                    if($type == "model") {
                        $html = "";

                        /*
                        $modelFields = $config["fields"];

                        $modelWrapper = view("Centauri::Backend.Modals.NewContentElement.Fields.model", [
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

                            $_html = view("Centauri::Backend.Modals.NewContentElement.Fields." . $modelType, [
                                "id" => $modelFieldName,
                                "label" => $modelLabel,
                                "additionalData" => [],
                                "config" => $modelConfig
                            ])->render();

                            $modelWrapper = str_replace("###MODEL_CONTENT###", $_html, $modelWrapper);
                            $html = $modelWrapper;
                        }
                        */
                    } else {
                        // $html = view("Centauri::Backend.Modals.NewContentElement.Fields." . $type, [
                        //     "id" => $ctype,
                        //     "label" => $label,
                        //     "additionalData" => $additionalData,
                        //     "config" => $config
                        // ])->render();

                        $html = $this->renderHtmlByField($field, [
                            "id" => $ctype,
                            "uid" => "",
                            "additionalData" => $additionalData
                        ], "");
                    }
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

            // additionalData stuff for "special/custom fields"
            $additionalData = [];

            if(isset($GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$ctype])) {
                if(!isset($GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$ctype]["class"])) {
                    throw new Exception("AdditionalDataFuncs for CType '$ctype' has no specified class value!");
                }

                $additionalDataClassName = $GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$ctype]["class"];
                $additionalDataClass = Centauri::makeInstance($additionalDataClassName);

                if(method_exists($additionalDataClass, "onEditListener")) {
                    $returns = $GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$ctype]["return_statement"] ?? 0;

                    if($returns) {
                        return $additionalDataClass->onEditListener($element);
                    }

                    $additionalDataClass->onEditListener($element);
                }
            }

            $CCE = config("centauri")["CCE"];
            $elements = $CCE["elements"];

            $elementShowsFields = $elements[$ctype];

            $__html = "";

            foreach($elementShowsFields as $fieldKey => $field) {
                if(is_array($field)) {
                    $__html .= $this->renderField($fieldKey, $element);
                } else {
                    $__html .= $this->renderField($field, $element);
                }
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
                    $inlineparent = $dataObj["inlineparent"] ?? "";

                    if($inline && $inline != "" && gettype($inline) == "string") {
                        $inlineRecords[] = $dataObj;
                    } else {
                        if($type == "NORMAL" && !is_null($element)) {
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

                // dd($inlineRecords);

                foreach($inlineRecords as $inlineRecord) {
                    $inline = $inlineRecord["inline"];
                    $inlineparent = $inlineRecord["inlineparent"];

                    $uid = $inlineRecord["uid"];
                    $id = explode("-", $inlineRecord["id"])[0];
                    $value = $inlineRecord["value"];

                    if($inline == $inlineparent) {
                        $CCEfield = $CCEfields[$inline];

                        $modelClass = $CCEfield["config"]["model"];
                        $model = $modelClass::where("uid", $uid)->get()->first();

                        // if(!is_null($id) && !is_null($value) && isset($model->$id)) {
                            $model->$id = $value;
                            $model->save();
                        // }
                    } else {
                        $CCEfield = $CCEfields[$inlineparent]["config"]["fields"][$inline];

                        $modelClass = $CCEfield["config"]["model"];
                        $model = $modelClass::where("uid", $uid)->get()->first();

                        $model->$id = $value;
                        $model->save();
                    }
                }

                if(empty($inlineRecords)) {
                    $element->save();
                }

                return json_encode([
                    "type" => "success",
                    "title" => "Element saved",
                    "description" => "This element has been saved"
                ]);
            }

            if($ajaxName == "hideElementByUid") {
                $state = ($element->hidden ? "hidden" : "visible");

                $element->hidden = !$element->hidden;

                if($element->save()) {
                    return json_encode([
                        "type" => "primary",
                        "title" => "Element Visibility",
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

        if($ajaxName == "sortElement") {
            $data = $request->input("data");

            $parent = $data["parent"];

            $rowPos = $data["rowpos"];
            $colPos = $data["colpos"];

            $currentElementUid = $data["currentElementUid"];
            $currentSorting = $data["currentSorting"];
            $sortto = $data["sortto"];

            $targetuid = $data["targetuid"] ?? -1;
            $direction = $data["direction"];

            $crtElement = Element::where("uid", $currentElementUid)->get()->first();

            $element = Element::where([
                "sorting" => $sortto,
                "rowPos" => $rowPos,
                "colPos" => $colPos
            ])->get()->first();

            $crtElement->rowPos = $rowPos;
            $crtElement->colPos = $colPos;

            if($parent == "grid") {
                $parentUid = $data["parentUid"];
            }

            $crtElement->save();

            if($direction == "before") {
                $elements = Element::where("sorting", ">=", $sortto)->get()->all();

                foreach($elements as $element) {
                    $eSorting = $element->sorting;

                    if($element->uid == $crtElement->uid) {
                        $eSorting--;
                    } else {
                        $eSorting++;
                    }

                    $element->sorting = $eSorting;
                    $element->save();
                }
            }

            if($direction == "after") {
                $elements = Element::where("sorting", "<=", $sortto)->get()->all();

                foreach($elements as $element) {
                    $eSorting = $element->sorting;

                    if($element->uid == $crtElement->uid) {
                        $eSorting++;
                    } else {
                        $eSorting--;
                    }

                    $element->sorting = $eSorting;
                    $element->save();
                }
            }

            return json_encode([
                "type" => "success",
                "title" => "Element moved",
                "description" => "Successfully moved this element"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }

    public function saveElementByField($field, $uid, $attribute, $value)
    {
        dd($field, $uid, $attribute, $value);
    }
}
