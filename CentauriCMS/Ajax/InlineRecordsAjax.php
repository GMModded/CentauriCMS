<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Exception\InlineRecordException;
use Centauri\CMS\Helper\ModelsHelper;
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

            $CCE = config("centauri")["CCE"];
            $CCEfields = $CCE["fields"];

            $modelConfig = $CCEfields[$parentmodelid]["config"]["fields"][$modelid];

            $modelNamespace = $modelConfig["config"]["model"];
            $parentUidName = $modelConfig["config"]["parent_uid"] ?? "parent_uid";

            $model = new $modelNamespace;
            $model->$parentUidName = $parentuid;
            $_lastSortingVal = $modelNamespace::latest()->value("sorting");
            $model->sorting = $_lastSortingVal + 1;

            $model->save();

            $modelHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
                "uid" => $model->uid,
                "sorting" => 0
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

            $CCE = config("centauri")["CCE"];
            $CCEfields = $CCE["fields"];

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

        return AjaxAbstract::default($request, $ajaxName);
    }
}
