<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Centauri;
use Centauri\CMS\Event\OnNewElementEvent;
use Centauri\CMS\Exception\CentauriException;
use Centauri\CMS\Helper\CCEHelper;
use Centauri\CMS\Model\Element;
use Centauri\CMS\Model\FileReference;
use Centauri\CMS\Traits\AjaxTrait;
use Centauri\CMS\Utility\DomainsUtility;
use Centauri\CMS\Utility\ToastUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContentElementsAjax
{
    use AjaxTrait;

    /**
     * Centauri Core class.
     * 
     * @var Centauri
     */
    protected $Centauri;

    public function __construct()
    {
        $this->Centauri = Centauri::makeInstance(Centauri::class);
    }

    /**
     * Renders the backend-view of a page if found, else throwing a toast-error notification with given description.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findByPidAjax(Request $request)
    {
        $uid = $request->input("pid");
        $lid = $request->input("lid") ?? 1;
        $rootpageid = $request->input("rootpageid") ?? null;

        // Getting Page and checking whether the host (domain-record) of this page exists at all
        $page = \Centauri\CMS\Model\Page::where("uid", $uid)->get()->first();

        $domainConfig = null;

        if(!is_null($rootpageid)) {
            $domainConfig = DomainsUtility::findDomainConfigByPageUid($rootpageid);
        } else {
            $domainConfig = DomainsUtility::findDomainConfigByPageUid($page->uid);
        }

        if(is_null($domainConfig) && $page->page_type == "rootpage") {
            return response("This root-page (UID: '" . $page->uid . "') seems to have no configured Domain - fix this issue by creating a domain record for this page.", 500);
        }

        // dd($domainConfig);

        $host = DomainsUtility::getUriByConfig($domainConfig);
        if($domainConfig->domain != $page->slugs) {
            $page->uri = $host . $page->slugs;
        } else {
            $page->uri = $host;
        }

        if($host == "/") {
            $page->uri = $page->slugs;
        }

        $elements = Element::where([
            "pid" => $uid,
            "lid" => $lid
        ])->orderBy("sorting", "asc")->get()->all();

        $CCE = config("centauri")["CCE"];
        $fields = CCEHelper::getAllFields();

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
                "page" => $page,
                "beLayout" => $backendLayout,
                "elements" => $elements,
                "fields" => $fields
            ]
        ])->render();
    }

    /**
     * Returns Centauri's configured ContentElements array with additional those of third-party-extensions.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function getConfigCCEAjax(Request $request)
    {
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

            /** Overwrites of $field by $fieldConfiguration */
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

            if(!$type) {
                $additionalData = $this->findAdditionalDataByType([
                    "type" => $type
                ]);
            }

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

    /**
     * Creates a new element on by a given pid (page-uid).
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function newElementAjax(Request $request)
    {
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
                            foreach($fieldsValues as $field => $fieldDataArr) {
                                $value = $fieldDataArr["value"];
                                $element->setAttribute($field, $value);
                            }
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

        event(new OnNewElementEvent([
            "reloadpage" => true,
            "uid" => $element->pid
        ]));

        return json_encode([
            "type" => "success",
            "title" => "Element created",
            "description" => "This element has been created"
        ]);
    }

    /**
     * Finds fields for an element given by its uid for editing them in the pages-module using the pagetree.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findFieldsByUidAjax(Request $request)
    {
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

        if(is_null($elementShowsFields)) {
            return response("This element has no shown-fields configuration.", 500);
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

    /**
     * Saves an element's fields by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function saveElementByUidAjax(Request $request)
    {
        $uid = $request->input("uid");
        $element = Element::where("uid", $uid)->get()->first();

        $datas = $request->input("datas");
        $datasArr = json_decode($datas, true);
        $tableInfo = $request->input("tableInfo");

        $CCEfields = CCEHelper::getAllFields();

        foreach($datasArr as $key => $arr) {
            $key = $tableInfo[$key];

            foreach($arr as $uid => $fieldsValues) {
                if($key == "elements") {
                    $element = Element::where("uid", $uid)->get()->first();

                    foreach($fieldsValues as $field => $fieldDataArr) {
                        if(
                            (Str::contains($field, "image_") ||
                                Str::contains($field, "file_")
                            ) && 

                            Str::contains($field, ":")
                        ) {
                            $field = str_replace("file_", "", $field);
                            $field = str_replace("image_", "", $field);

                            $explField = explode(":", $field);

                            $imageColumn = $explField[0];
                            $elementUid = $explField[1];
                            $fileReferenceUid = $explField[2];

                            $fileReference = FileReference::where("uid", $fileReferenceUid)->get()->first();
                            $fileReference->$imageColumn = $fieldDataArr["value"];
                            $fileReference->save();
                        } else {
                            $value = $fieldDataArr["value"];

                            $values = [];

                            if($CCEfields[$field]["type"] == "file" || $CCEfields[$field]["type"] == "image") {
                                if(Str::contains($value, ",")) {
                                    $values = explode(",", $value);
                                } else {
                                    $values = [$value];
                                }

                                foreach($values as $imgUid) {
                                    $fileReference = FileReference::where("uid_element", $element->uid)->get()->first();

                                    if(is_null($fileReference)) {
                                        $fileReference = new FileReference;

                                        $fileReference->uid_element = $element->uid;
                                        $fileReference->uid_image = $imgUid;

                                        $fileReference->fieldname = $field;
                                        $fileReference->tablename = "elements";

                                        $fileReference->save();
                                    }
                                }
                            }

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
                                    $element->setAttribute($field, $value);
                                }
                            } else {
                                $element->setAttribute($field, $value);
                            }
                        }
                    }

                    try {
                        $element->save();
                    } catch (\Illuminate\Database\QueryException $e) {
                        return response($e->getMessage(), 500);
                    }
                } else {
                    if($key == "undefined") {
                        dd($tableInfo);
                    }

                    $modelClass = $CCEfields[$key]["config"]["model"];
                    $model = $modelClass::where("uid", $uid)->get()->first();

                    foreach($fieldsValues as $field => $fieldDataArr) {
                        $value = $fieldDataArr["value"];

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

                    try {
                        $element->save();
                    } catch (\Illuminate\Database\QueryException $e) {
                        return response($e->getMessage(), 500);
                    }
                }
            }
        }

        event(new OnNewElementEvent([
            "reloadpage" => true,
            "uid" => $element->pid
        ]));

        return json_encode([
            "type" => "success",
            "title" => "Element saved",
            "description" => "This element has been saved"
        ]);
    }

    /**
     * Hides/Shows an element by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function hideElementByUidAjax(Request $request)
    {
        $uid = $request->input("uid");
        $element = Element::where("uid", $uid)->get()->first();

        $state = (!$element->hidden ? "hidden" : "visible");
        $element->hidden = !$element->hidden;

        event(new OnNewElementEvent([
            "reloadpage" => true,
            "uid" => $element->pid
        ]));

        if($element->save()) {
            return json_encode([
                "type" => "primary",
                "title" => "Element Visibility",
                "description" => "This element is $state now"
            ]);
        }
    }

    /**
     * Delets an element-record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deleteElementByUidAjax(Request $request)
    {
        $uid = $request->input("uid");
        $element = Element::where("uid", $uid)->get()->first();

        $elementPid = $element->pid ?? null;

        if(!is_null($element) && ($element->delete())) {
            event(new OnNewElementEvent([
                "reloadpage" => true,
                "uid" => $elementPid
            ]));

            return json_encode([
                "type" => "success",
                "title" => "Element deleted",
                "description" => "This element has been deleted"
            ]);
        }
    }

    /**
     * Saves an image according to its parent-element uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function saveImageToElementByUidAjax(Request $request)
    {
        $uid = $request->input("uid");
        $field = $request->input("field");
        $stringUids = $request->input("stringUids");

        $element = Element::where("uid", $uid)->get()->first();
        $element->$field = $stringUids;
        $element->save();
    }

    /**
     * Sorts an element to a new position.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function sortElementAjax(Request $request)
    {
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

        event(new OnNewElementEvent([
            "reloadpage" => true,
            "uid" => $pid
        ]));

        return json_encode([
            "type" => "primary",
            "title" => "Element moved",
            "description" => "This element has been moved"
        ]);
    }

    /**
     * Helper-method for this class itself when rendering a field by its config, data and optional parent.
     * 
     * @param array $fieldConfig The configuration-array of a field.
     * @param array $data The data-array of a field.
     * @param string $parent The parent of the given field.
     * 
     * @return string
     */
    public function renderHtmlByField($fieldConfig, $data, $parent = "")
    {
        if(!isset($fieldConfig["type"])) {
            return;
        }

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
                    "model" => $model
                ])->render();

                $existingItemLabel = $fieldConfig["existingItemLabel"];
                $top = $model->$existingItemLabel ?? $fieldConfig["listLabel"] ?? "Item";

                $bottom = "";
                foreach($fieldConfig["config"]["fields"] as $_key => $_field) {
                    $bottom .= $this->renderField((is_int($_key) ? $_field : $_key), $model, $fieldConfig["id"]);
                }

                $splittedTop = explode(" ", $top);
                $nSpittedTop = "";

                foreach($splittedTop as $topItem) {
                    if(Str::contains($topItem, "{") && Str::contains($topItem, "}")) {
                        $topItem = str_replace("{", "", $topItem);
                        $topItem = str_replace("}", "", $topItem);

                        if(isset($model->$topItem)) {
                            $nSpittedTop .= $model->$topItem . " ";
                        }
                    }
                }

                if($nSpittedTop == "") {
                    $nSpittedTop = $fieldConfig["listLabel"];
                }

                $_modelsHtml = str_replace("###MODEL_CONTENT_TOP###", $nSpittedTop, $_modelsHtml);
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

                $element = Element::where("uid", $data["uid"])->get()->first();
                $additionalData = $this->findAdditionalDataByType([
                    "type" => $additionalType,
                    "additionalType" => $additionalType,
                    "element" => $element
                ]);

                $html = view("Centauri::Backend.Modals.NewContentElement.Fields.AdditionalTypes." . $additionalType, [
                    "fieldConfig" => $fieldConfig,
                    "additionalData" => $additionalData,
                    "element" => $element
                ])->render();
            } else {
                $type = $fieldConfig["type"];

                $additionalData = $this->findAdditionalDataByType([
                    "type" => $type
                ]);

                $html = view("Centauri::Backend.Modals.NewContentElement.Fields." . $type, [
                    "fieldConfig" => $fieldConfig,
                    "additionalData" => $additionalData
                ])->render();
            }
        }

        return $html;
    }

    /**
     * Helper-method for this class itself when rendering a single field - also used by $this->renderHtmlByField() method.
     * 
     * @param array $field The field-array which should get rendered.
     * @param array|\Centauri\CMS\Model\Element $element Array or instance of the element object.
     * @param string $parent The parent of the given field.
     * 
     * @return string|void
     */
    public function renderField($field, $element, $parent = "")
    {
        $html = "";
        $splittedFields = [];

        $CCEfields = CCEHelper::getAllFields();

        if(Str::contains($field, ";")) {
            $splittedFields = explode(";", $field);
        }

        if(!empty($splittedFields)) {
            foreach($splittedFields as $_key => $_field) {
                if(!isset($CCEfields[$_field]) && !isset($CCEfields[$parent]["config"]["fields"][$_field]) && !isset($CCEfields[$parent]["fields"][$_field])) {
                    $msg = "CCE - The configuration for field '" . $field . "' could not be found.";

                    if($parent != "") {
                        $msg = "CCE - The configuration for child-field '" . $field . "' of parent '" . $parent . "' could not be found.";
                    }

                    return $this->Centauri->throwException($msg, true);
                }

                if($parent != "") {
                    $fieldConfig = $CCEfields[$parent]["config"]["fields"][$_field] ?? ($CCEfields[$parent]["fields"][$_field] ?? null);
                } else {
                    $fieldConfig = $CCEfields[$_field];
                }

                $html .= "<div class='col" . (isset($fieldConfig["colAdditionalClasses"]) ? " " . $fieldConfig["colAdditionalClasses"] : "") . "'>" . $this->renderHtmlByField($fieldConfig, [
                    "id" => $_field,
                    "value" => $element->$_field ?? "",
                    "uid" => $element->uid
                ], $parent) . "</div>";
            }

            $html = "<div class='col-12 d-flex px-0 ml-n2' style='max-width: calc(100% + 1rem); width: calc(100% + 1rem);'>" . $html . "</div>";
        } else {
            if(!isset($CCEfields[$field]) && !isset($CCEfields[$parent]["config"]["fields"][$field]) && !isset($CCEfields[$parent]["fields"][$field])) {
                $msg = "CCE - The configuration for field '" . $field . "' could not be found.";

                if($parent != "") {
                    $msg = "CCE - The configuration for child-field '" . $field . "' of parent '" . $parent . "' could not be found.";
                }

                return $this->Centauri->throwException($msg, true);
            }

            $fieldConfig = [];

            if($parent != "") {
                $fieldConfig = $CCEfields[$parent]["config"]["fields"][$field] ?? ($CCEfields[$parent]["fields"][$field] ?? null);
            } else {
                $fieldConfig = $CCEfields[$field];
            }

            $additionalData = $this->findAdditionalDataByType([
                "type" => $fieldConfig["type"],
                "ctype" => "grid",
                "method" => "findFieldsByUid",
                "element" => $element
            ]);

            $html .= $this->renderHtmlByField($fieldConfig, [
                "id" => $field,
                "value" => $element->$field ?? "",
                "uid" => $element->uid,
                "isInlineRecord" => ($parent != "")
            ], $parent);

            if(isset($fieldConfig["dd(return_statement"])) {
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

    /**
     * Helper-method for this class itself when finding AdditionalData by its type.
     * 
     * @param array $type
     * 
     * @return void
     */
    public function findAdditionalDataByType($data)
    {
        $type = ($data["type"] ?? false);

        if(!$type) {
            return;
        }

        if(isset($GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$type])) {
            $additionalDataClassName = $GLOBALS["Centauri"]["AdditionalDataFuncs"]["ContentElements"][$type]["class"];
            $additionalDataClass = Centauri::makeInstance($additionalDataClassName);

            $method = $data["method"] ?? "getAdditionalData";

            $adtData = $additionalDataClass->$method($data);

            if($adtData instanceof \Illuminate\Http\Response) {
                Centauri::makeInstance(CentauriException::class)->throw($adtData->getContent(), true);
            }

            return $adtData;
        }

        return null;
    }
}
