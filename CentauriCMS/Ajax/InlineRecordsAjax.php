<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Exception\InlineRecordException;
use Centauri\CMS\Helper\CCEHelper;
use Centauri\CMS\Helper\ModelsHelper;
use Centauri\CMS\Model\Element;
use Centauri\CMS\Model\File;
use Exception;
use Illuminate\Support\Str;

class InlineRecordsAjax implements AjaxInterface
{
    public function request(\Illuminate\Http\Request $request, string $ajaxName)
    {
        if($ajaxName == "list") {
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
                    $files[] = File::where("uid", $uid)->get()->first();
                }

                return view("Centauri::Backend.Modals.inlineRecords", [
                    "type" => $type,
                    "files" => $files
                ]);
            }

            if($type == "models") {
                $namespace = $request->input("namespace");

                $modelInstance = new $namespace;
                $models = $modelInstance::orderBy("sorting", "asc")->get()->all();

                $CMEs = ModelsHelper::getAllCMEs();
                $modelConfig = $CMEs["models"][$namespace] ?? null;

                if(is_null($modelConfig)) {
                    throw new Exception("Hm, looks like the model with the namespace '" . $namespace . "' has not been registered yet!");
                }

                return view("Centauri::Backend.Partials.InlineRecords.listModels", [
                    "models" => $models,
                    "config" => $modelConfig,
                    "namespace" => $namespace
                ])->render();
            }
        }

        if($ajaxName == "create") {
            $parentuid = $request->input("parentuid");
            $parentmodelid = $request->input("parentname");
            $modelid = $request->input("name");

            if(!$modelid || $modelid == "") {
                throw new InlineRecordException("CCE - InlineRecord - The 'modelid' (name-parameter) can't be empty/not setted!");
            }

            $ContentElementAjax = Centauri::makeInstance(ContentElementsAjax::class);

            $CCEfields = CCEHelper::getAllFields();

            $parentModelConfig = $CCEfields[$parentmodelid]["config"] ?? null;
            $parentModelNamespace = null;

            if(!is_null($parentModelConfig)) {
                $parentModelNamespace = $parentModelConfig["model"];
            }

            $modelConfig = $CCEfields[$parentmodelid]["config"]["fields"][$modelid] ?? $CCEfields[$parentmodelid] ?? null;

            $modelNamespace = $modelConfig["config"]["model"];
            $parentUidName = $modelConfig["config"]["parent_uid"] ?? "parent_uid";

            $parentElement = $parentModelNamespace::where("uid", $parentuid)->get()->first();

            if(
                is_null($parentElement) &&
                ($parentmodelid == $modelid)
            ) {
                $parentElement = Element::where("uid", $parentuid)->get()->first();
            }

            $lid = $parentElement->getAttribute("lid");

            $model = new $modelNamespace;
            $model->$parentUidName = $parentuid;
            $_lastSortingVal = $modelNamespace::latest()->value("sorting");
            $model->sorting = $_lastSortingVal + 1;
            $model->lid = $lid;

            $model->save();

            $modelHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
                "model" => $model
            ])->render();

            $modelHtml = str_replace("###MODEL_CONTENT_TOP###", ($modelConfig["newItemLabel"] ?? "Item"), $modelHtml);

            $bottom = "";
            foreach($modelConfig["config"]["fields"] as $_key => $_field) {
                $bottom .= $ContentElementAjax->renderField((is_int($_key) ? $_field : $_key), $model, $modelid);
            }

            $modelHtml = str_replace("###MODEL_CONTENT_BOTTOM###", $bottom, $modelHtml);

            $model->save();

            $html = str_replace("###MODEL_CONTENT###", "", $modelHtml);
            return $html;
        }

        if($ajaxName == "edit") {
            $uid = $request->input("uid");
            $namespace = $request->input("namespace");

            $modelInstance = new $namespace;
            $model = $modelInstance::where("uid", $uid)->get()->first();

            if(is_null($model)) {
                return response("Looks like this Inline-Record does not exists anymore... Does it has been deleted by a previous action (may from another user)?", 500);
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
                ], "");
            }

            return view("Centauri::Backend.Partials.InlineRecords.editModel", [
                "renderedHtmlFields" => $html,
                "model" => $model
            ])->render();

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
        }

        if(
            $ajaxName == "hideIRByUid" ||
            $ajaxName == "deleteIRByUid"
        ) {
            $data = $request->input("data");

            $uid = $data["uid"];
            $type = $data["type"];
            $parenttype = $data["parenttype"];

            $CCEfields = CCEHelper::getAllFields();

            if($ajaxName == "hideIRByUid") {
                $modelConfig = $CCEfields[$data["type"]]["config"];
                $modelNamespace = $modelConfig["model"];
                $model = $modelNamespace::where("uid", $data["uid"])->get()->first();

                $state = (!$model->hidden ? "hidden" : "visible");

                $model->hidden = !$model->hidden;
                $model->save();

                return json_encode([
                    "type" => "primary",
                    "title" => "Inline-Record Visibility",
                    "description" => "This record is $state now"
                ]);
            }
        }

        if($ajaxName == "sortRecord") {
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

            return json_encode([
                "type" => "success",
                "title" => "Inline-Record Sorting",
                "description" => "Successfully updated sortings"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
