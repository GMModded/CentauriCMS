<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Centauri;
use Centauri\CMS\Event\OnNewElementEvent;
use Centauri\CMS\Exception\InlineRecordException;
use Centauri\CMS\Helper\CCEHelper;
use Centauri\CMS\Helper\ModelsHelper;
use Centauri\CMS\Model\Element;
use Centauri\CMS\Model\File;
use Centauri\CMS\Traits\AjaxTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InlineRecordsAjax
{
    use AjaxTrait;

    /**
     * Lists all inline-records of a parent-element (e.g. a normal content-element) when editing the content of a page.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function listAjax(Request $request)
    {
        $type = $request->input("type");

        if($type == "files") {
            $uids = $request->input("uids");

            if(Str::contains($uids, ",")) {
                $uids = explode(",", $uids);
            } else {
                $uids = [$uids];
            }

            $files = [];

            foreach($uids as $uid) {
                $files[$uid] = File::where("uid", $uid)->get()->first();
            }

            return view("Centauri::Backend.Modals.inlineRecords", [
                "type" => $type,
                "files" => $files
            ]);
        }

        if($type == "models") {
            $namespace = $request->input("namespace");

            $modelInstance = new $namespace;
            $models = $modelInstance::orderBy("sorting", "ASC")->get()->all();

            $CMEs = ModelsHelper::getAllCMEs();
            $modelConfig = $CMEs["models"][$namespace] ?? null;

            if(is_null($modelConfig)) {
                return response("Hm, looks like the model with the namespace '" . $namespace . "' has not been registered yet!", 500);
            }

            return view("Centauri::Backend.Partials.InlineRecords.listModels", [
                "models" => $models,
                "config" => $modelConfig,
                "namespace" => $namespace
            ])->render();
        }
    }

    /**
     * Create method of a new InlineRecord for a content-element.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function createAjax(Request $request)
    {
        $parentuid = $request->input("parentuid");
        $parentmodelid = $request->input("parentname");
        $modelid = $request->input("name");

        if(!$modelid || $modelid == "") {
            throw new InlineRecordException("CCE - InlineRecord - The 'modelid' (name-parameter) can't be empty/not setted!");
        }

        $ContentElementAjax = Centauri::makeInstance(ContentElementsAjax::class);
        $CCEfields = CCEHelper::getAllFields();

        $parentModelConfig = $CCEfields[$parentmodelid]["config"] ?? ($CCEfields[$parentmodelid] ?? null);
        $parentModelNamespace = null;

        if(!is_null($parentModelConfig)) {
            $parentModelNamespace = $parentModelConfig["model"] ?? $parentModelConfig["namespace"];
        } else {
            return response("The '$parentmodelid'-model ID has not been configured in CCE yet!", 500);
        }

        $modelConfig = $CCEfields[$parentmodelid]["config"]["fields"][$modelid] ?? ($CCEfields[$parentmodelid]["fields"] ?? null);
        $modelConfig = $modelConfig[$modelid];

        $modelNamespace = $modelConfig["config"]["model"];
        $parentUidName = $modelConfig["config"]["parent_uid"] ?? "parent_uid";

        if($parentuid == "NEW") {
            dd(request()->input(), $parentModelConfig);
        } else {
            $parentElement = $parentModelNamespace::where("uid", $parentuid)->get()->first();

            if(is_null($parentElement) && ($parentmodelid == $modelid)) {
                $parentElement = Element::where("uid", $parentuid)->get()->first();
            }

            $lid = $parentElement->getAttribute("lid");

            $model = new $modelNamespace;

            $model->$parentUidName = $parentuid;
            $model->lid = $lid;

            $_lastSortingVal = $modelNamespace::latest()->value("sorting");
            $model->sorting = $_lastSortingVal + 1;

            $model->save();

            $modelHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
                "model" => $model
            ])->render();

            $newItemLabel = $modelConfig["newItemLabel"] ?? "Item";

            $splittedTop = explode(" ", $newItemLabel);
            $nSpittedTop = "";

            foreach($splittedTop as $topItem) {
                if(\Str::contains($topItem, "{") && \Str::contains($topItem, "}")) {
                    $topItem = str_replace("{", "", $topItem);
                    $topItem = str_replace("}", "", $topItem);

                    if(isset($model->$topItem)) {
                        $nSpittedTop .= $model->$topItem . " ";
                    }
                }
            }

            if($nSpittedTop == "") {
                $nSpittedTop = $modelConfig["listLabel"];
            }

            $modelHtml = str_replace("###MODEL_CONTENT_TOP###", $nSpittedTop, $modelHtml);

            $bottom = "";
            foreach($modelConfig["config"]["fields"] as $_key => $_field) {
                $bottom .= $ContentElementAjax->renderField($_field, $model, $modelNamespace);
            }

            $modelHtml = str_replace("###MODEL_CONTENT_BOTTOM###", $bottom, $modelHtml);

            $html = str_replace("###MODEL_CONTENT###", "", $modelHtml);
            return $html;
        }
    }

    /**
     * This will handle the fields which can be edit from an Inline-Record inside a content-element
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function editAjax(Request $request)
    {
        $uid = $request->input("uid");
        $namespace = $request->input("namespace");

        $modelInstance = new $namespace;
        $model = $modelInstance::where("uid", $uid)->get()->first();

        if(is_null($model)) {
            return response("Looks like this Inline-Record does not exists anymore... does it has been deleted by a previous action (may from another user)?", 500);
        }

        $CMEs = ModelsHelper::getAllCMEs();
        $modelConfig = $CMEs["models"][$namespace] ?? null;

        if(is_null($modelConfig)) {
            return response("Hm, looks like the model with the namespace '" . $namespace . "' (uid " . $uid . ") has not been registered yet?", 500);
        }

        $fields = $modelConfig["fields"];

        $ContentElementAjax = Centauri::makeInstance(ContentElementsAjax::class);
        $html = "";

        foreach($fields as $id => $field) {
            $html .= $ContentElementAjax->renderHtmlByField($field, [
                "id" => $id,
                "value" => $model->$id ?? "",
                "uid" => $model->uid
            ], $namespace);
        }

        return view("Centauri::Backend.Partials.InlineRecords.editModel", [
            "renderedHtmlFields" => $html,
            "model" => $model
        ])->render();

        /*
        $CCEfields = CCEHelper::getAllFields();

        $modelConfig = $CCEfields[$parentmodelid]["config"]["fields"][$modelid];

        $modelNamespace = $modelConfig["config"]["model"];
        $parentUidName = $modelConfig["config"]["parent_uid"] ?? "parent_uid";

        $modelHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
            "uid" => $model->uid,
            "sorting" => 0
        ])->render();

        $modelHtml = str_replace("###MODEL_CONTENT_TOP###", ($modelConfig["newItemLabel"] ?? "Item"), $modelHtml);

        $bottom = "";
        foreach($modelConfig["config"]["fields"] as $_key => $_field) {
            $bottom .= $ContentElementAjax->renderField((is_int($_key) ? $_field : $_key), $model, $modelid);
        }
        */
    }

    /**
     * Hides an Inline-Record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function hideIRByUidAjax(Request $request)
    {
        $data = $request->input("data");

        $uid = $data["uid"];
        $type = $data["type"];

        $CCEfields = CCEHelper::getAllFields();

        $modelConfig = $CCEfields[$type]["config"];
        $modelNamespace = $modelConfig["model"];
        $model = $modelNamespace::where("uid", $uid)->get()->first();

        $state = (!$model->hidden ? "hidden" : "visible");

        $model->hidden = !$model->hidden;
        $model->save();

        event(new OnNewElementEvent([
            "reloadpage" => true,
            "uid" => $model->pid
        ]));

        return json_encode([
            "type" => "primary",
            "title" => "Inline-Record Visibility",
            "description" => "This record is $state now"
        ]);
    }

    /**
     * Delets an Inline-Record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deleteIRByUidAjax(Request $request)
    {
        $data = $request->input("data");

        $uid = $data["uid"];
        $type = $data["type"];

        $model = $type::where("uid", $uid)->get()->first();
        $model->delete();

        return json_encode([
            "type" => "warning",
            "title" => "Inline-Record deleted",
            "description" => "This record has been deleted."
        ]);
    }

    /**
     * Sorting of a single Inline-Record.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function sortRecordAjax(Request $request)
    {
        $uid = $request->input("uid");
        $element = Element::where("uid", $uid)->get()->first();

        $data = $request->input("data");
        $type = $request->Input("type");
        $parenttype = $request->Input("parenttype");

        $CCEfields = CCEHelper::getAllFields();

        $modelNamespace = $CCEfields[$type]["config"]["model"];

        foreach($data as $record) {
            $irUid = $record["uid"];
            $irSorting = $record["sorting"];

            $model = $modelNamespace::where("uid", $irUid)->get()->first();
            $model->sorting = $irSorting;
            $model->save();
        }

        event(new OnNewElementEvent([
            "reloadpage" => true,
            "uid" => $element->pid
        ]));

        return json_encode([
            "type" => "success",
            "title" => "Inline-Record Sorting",
            "description" => "Successfully updated sortings"
        ]);
    }

    /**
     * Saving an Inline-Record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function saveModelByUidAjax(Request $request)
    {
        $data = $request->input("data");

        $failed = false;

        foreach($data as $namespace => $models) {
            foreach($models as $modelUid => $modelFieldsArr) {
                $modelInstance = new $namespace;
                $model = $modelInstance::where("uid", $modelUid)->get()->first();

                foreach($modelFieldsArr as $columnFieldName => $field) {
                    $value = $field["value"];

                    /** @todo Find a better way to achieve the same goal here? */
                    if($value === "false") {
                        $value = 0;
                    } else if($value === "true") {
                        $value = 1;
                    }

                    $model->$columnFieldName = $value;
                }

                if(!$model->save()) {
                    $failed = true;
                }
            }
        }

        if(!$failed) {
            return json_encode([
                "type" => "success",
                "title" => "Inline-Record",
                "description" => "This record has been saved."
            ]);
        }

        return response("Looks like this Inline-Record could not be saved... Does it has been deleted by a previous action (may from another BE user)?", 500);
    }
}
