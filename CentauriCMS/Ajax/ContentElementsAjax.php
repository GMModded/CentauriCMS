<?php
namespace Centauri\CMS\Ajax;

use Exception;
use Centauri\CMS\AjaxAbstract;
use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Helper\CCEHelper;
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
            if(!isset($fieldConfig["value"])) {
                $fieldConfig["value"] = "";
            }

            if(isset($fieldConfig["additionalType"])) {
                $additionalType = $fieldConfig["additionalType"];

                $additionalData = $this->findAdditionalDataByType($additionalType);

                $html = view("Centauri::Backend.Modals.NewContentElement.Fields.AdditionalTypes." . $additionalType, [
                    "fieldConfig" => $fieldConfig,
                    "additionalData" => $additionalData
                ])->render();
            } else {
                $additionalData = $this->findAdditionalDataByType($fieldConfig["type"]);

                $html = view("Centauri::Backend.Modals.NewContentElement.Fields." . $fieldConfig["type"], [
                    "fieldConfig" => $fieldConfig,
                    "additionalData" => $additionalData
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
        $CCEfields = CCEHelper::getAllFields();

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

            $html = "<div class='col-12 d-flex px-0 ml-n2' style='max-width: calc(100% + 1rem); width: calc(100% + 1rem);'>" . $html . "</div>";
        } else {
            if(!isset($CCEfields[$field]) && !isset($CCEfields[$parent]["config"]["fields"][$field])) {
                $msg = "CCE - The configuration for field '" . $field . "' could not be found.";

                if($parent != "") {
                    $msg = "CCE - The configuration for child-field '" . $field . "' of parent '" . $parent . "' could not be found.";
                }

                throw new Exception($msg);
            }

            $fieldConfig = [];

            if($parent != "") {
                $fieldConfig = $CCEfields[$parent]["config"]["fields"][$field];
            } else {
                $fieldConfig = $CCEfields[$field];
            }

            $additionalData = $this->findAdditionalDataByType($fieldConfig["type"], "grid", $element);

            $html .= $this->renderHtmlByField($fieldConfig, [
                "id" => $field,
                "value" => $element->$field ?? "",
                "uid" => $element->uid,
                "isInlineRecord" => ($parent != "")
            ], $parent);

            if(isset($fieldConfig["return_statement"])) {
                switch($fieldConfig["return_statement"]) {
                    case "RETURN":
                        return $additionalData;
                        break;

                    case "MERGE":
                        $html .= $additionalData;
                        break;

                    default:
                        break;
                }
            }
        }

        return $html;
    }

    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "findByPid") {
            $uid = $request->input("pid");
            $lid = $request->input("lid") ?? 1;

            $elements = Element::where([
                "pid" => $uid,
                "lid" => $lid,
                "hidden" => 0
            ])->orderBy("sorting", "asc")->get()->all();

            $CCE = config("centauri")["CCE"];
            $fields = CCEHelper::getAllFields();

            $page = \Centauri\CMS\Model\Page::where("uid", $uid)->get()->first();
            $backendLayout = config("centauri")["beLayouts"][$page->getAttribute("backend_layout")] ?? null;

            if(is_null($backendLayout)) {
                return response("Backend-Layout '" . $page->getAttribute("backend_layout") . "' not found for page with ID: " . $page->getAttribute("uid"), 500);
            }

            foreach($elements as $element) {
                if($element->ctype == "grids") {
                    $gridConfig = config("centauri")["gridLayouts"][$element->grid] ?? null;

                    if(!is_null($gridConfig)) {
                        $element->customTitle = $element->ctype . $gridConfig["label"];
                    }
                }
            }

            return view("Centauri::Backend.Partials.elements", [
                "data" => [
                    "beLayout" => $backendLayout,
                    "elements" => $elements,
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
            $fields = CCEHelper::getAllFields();

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

                $additionalData = $this->findAdditionalDataByType($type);

                if(!$isModel) {
                    // Model (Inline) Stuff
                    if($type == "model") {
                        $html = "";

                        foreach($field["config"]["fields"] as $fieldId => $fieldIdConfig) {
                            $html .= $this->renderHtmlByField($fieldIdConfig, [
                                "id" => $ctype,
                                "uid" => "",
                                "additionalData" => $additionalData
                            ], "");
                        }
                    } else {
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
            $lid = $request->input("lid") ?? 1;
            $rowPos = $request->input("rowPos") ?? 0;
            $colPos = $request->input("colPos") ?? 0;
            $ctype = $request->input("ctype");
            $insert = $request->input("insert");
            $type = $request->input("type");

            $element = null;
            $sorting = 0;

            if($insert == "before") {
                $sorting = $request->input("sorting");

                if(is_null($sorting)) {
                    return response("ContentElements - New Element's 'sorting'-value can't be 'null'", 500);
                }

                $elements = Element::where("sorting", ">", $sorting)->get()->all();
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

            $element = new Element;
            $element->pid = $pid;
            $element->lid = $lid;
            $element->rowPos = $rowPos;
            $element->colPos = $colPos;
            $element->ctype = $ctype;
            $element->sorting = $sorting;

            if($type == "ingrid") {
                $gridsparent = $request->input("gridsparent");
                $grids_sorting_rowpos = $request->input("grids_sorting_rowpos");
                $grids_sorting_colpos = $request->input("grids_sorting_colpos");

                $element->grids_parent = $gridsparent;
                $element->grids_sorting_rowpos = $grids_sorting_rowpos;
                $element->grids_sorting_colpos = $grids_sorting_colpos;
            }

            $datas = $request->input("datas");
            $datasArr = json_decode($datas, true);
            $tableInfo = $request->input("tableInfo");

            $CCEfields = config("centauri")["CCE"]["fields"];

            $model = null;

            foreach($datasArr as $key => $arr) {
                $key = $tableInfo[$key];

                foreach($arr as $uid => $fieldsValues) {
                    if($key == "elements" || $key == "") {
                        if($uid != "") {
                            $element = Element::where("uid", $uid)->get()->first();
                        }

                        foreach($fieldsValues as $field => $value) {
                            if(!isset($CCEfields[$field]["config"]["model"])) {
                                $element->setAttribute($field, $value);
                            }
                        }
                    } else {
                        $modelClass = $CCEfields[$key]["config"]["model"];
                        $model = $modelClass::where("uid", $uid)->get()->first();

                        foreach($fieldsValues as $field => $value) {
                            $model->setAttribute($field, $value);
                        }
                    }
                }
            }

            if(!is_null($model)) {
                $model->save();
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

            $elementShowsFields = $elements[$ctype] ?? null;

            foreach($GLOBALS["Centauri"]["ContentElements"] as $extension => $exArr) {
                if(isset($exArr["elements"])) {
                    if(isset($exArr["elements"][$ctype])) {
                        $elementShowsFields = $exArr["elements"][$ctype];
                    }
                }
            }

            $html = "";

            foreach($elementShowsFields as $fieldKey => $field) {
                if(is_array($field)) {
                    $html .= $this->renderField($fieldKey, $element);
                } else {
                    $html .= $this->renderField($field, $element);
                }
            }

            return view("Centauri::Backend.Partials.fieldForElement", [
                "element" => $element,

                "data" => [
                    "HTML" => $html
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
                $tableInfo = $request->input("tableInfo");

                $CCEfields = config("centauri")["CCE"]["fields"];

                $_fields = [];
                foreach($GLOBALS["Centauri"]["ContentElements"] as $extension => $arr) {
                    if(isset($arr["fields"])) {
                        foreach($arr["fields"] as $fieldCtype => $fieldArr) {
                            $_fields[$fieldCtype] = $fieldArr;
                        }
                    }
                }

                $CCEfields = array_merge($_fields, $CCEfields);

                foreach($datasArr as $key => $arr) {
                    $key = $tableInfo[$key];

                    foreach($arr as $uid => $fieldsValues) {
                        if($key == "elements") {
                            $element = Element::where("uid", $uid)->get()->first();

                            foreach($fieldsValues as $field => $value) {
                                $element->setAttribute($field, $value);
                            }

                            $element->save();
                        } else {
                            $modelClass = $CCEfields[$key]["config"]["model"];
                            $model = $modelClass::where("uid", $uid)->get()->first();

                            foreach($fieldsValues as $field => $value) {
                                if(isset($CCEfields[$field]["config"]["validation"])) {
                                    $class = $CCEfields[$field]["config"]["validation"];

                                    $validation = $class::validate([
                                        "field" => $field,
                                        "value" => $value,
                                        "CCE_FIELD" => $CCEfields[$field]
                                    ]);

                                    if(!$validation["state"]) {
                                        return $validation["result"];
                                    } else {
                                        $model->setAttribute($field, $value);
                                    }
                                } else {
                                    $model->setAttribute($field, $value);
                                }
                            }

                            $model->save();
                        }
                    }
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
            $pid = $request->input("pid");
            $dataArr = $request->input("data");

            foreach($dataArr as $index => $data) {
                $uid = $data["uid"];
                $sorting = $data["sorting"];
                $rowPos = $data["rowPos"];
                $colPos = $data["colPos"];
                $gridsparent = $data["gridsparent"];

                $element = Element::where([
                    "pid" => $pid,
                    "uid" => $uid
                ])->get()->first();

                if(!is_null($element)) {
                    $element->sorting = $sorting;
                    $element->rowpos = $rowPos;
                    $element->colpos = $colPos;

                    $grids_sorting_rowpos = $data["grids_sorting_rowpos"];
                    $grids_sorting_colpos = $data["grids_sorting_colpos"];

                    $element->grids_parent = $gridsparent;
                    $element->grids_sorting_rowpos = $grids_sorting_rowpos;
                    $element->grids_sorting_colpos = $grids_sorting_colpos;

                    $element->save();
                }
            }

            return json_encode([
                "type" => "primary",
                "title" => "Element moved",
                "description" => "This element has been moved"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }

    public function findAdditionalDataByType($type = null, $ctype = null, $element = null)
    {
        if(is_null($type) && !is_null($ctype)) {
            $type = $ctype;
        }

        if(isset($GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$type])) {
            $additionalDataClassName = $GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$type]["class"];
            $additionalDataClass = Centauri::makeInstance($additionalDataClassName);

            if(!method_exists($additionalDataClass, "fetch")) {
                throw new Exception("Could not find 'fetch'-method in AdditionalData class of '" . $additionalDataClassName . "'!");
            }

            if(!is_null($ctype) && !is_null($element)) {
                if(method_exists($additionalDataClass, "onEditListener")) {
                    $returns = $GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$ctype]["return_statement"] ?? 0;

                    if($returns) {
                        return $additionalDataClass->onEditListener($element);
                    }

                    $additionalDataClass->onEditListener($element);
                }
            }

            return $additionalDataClass->fetch();
        }

        return null;
    }
}
