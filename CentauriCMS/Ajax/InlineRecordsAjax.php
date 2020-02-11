<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Exception\InlineRecordException;
use Centauri\CMS\Model\File;
use Exception;
use Illuminate\Support\Facades\DB;
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
        }

        if($ajaxName == "create") {
            $parentuid = $request->input("parentuid");
            $parentmodelid = $request->input("parentname");
            $modelid = $request->input("name");

            if(!$modelid || $modelid == "") {
                throw new InlineRecordException("CCE - InlineRecord - The 'modelid' (name-parameter) can't be empty/not setted!");
            }

            $CCE = config("centauri")["CCE"];

            // if(!isset($CCE["fields"][$modelid]) || empty($CCE["fields"][$modelid])) {
            //     throw new InlineRecordException("CCE - InlineRecord - There are no models defined in 'fields => $modelid' for this model!");
            // }

            $elements = $CCE["elements"];
            $elementFields = $elements;

            $modelData = null;

            if($parentmodelid == $modelid) {
                $modelData = $CCE["fields"][$modelid];
            } else {
                $modelData = $CCE["fields"][$parentmodelid]["config"]["fields"][$modelid];
            }

            $model = new $modelData["config"]["model"];
            $model->setAttribute("parent_uid", $parentuid);
            $model->setAttribute("sorting", 1);
            $model->save();

            $html = view("Centauri::Backend.Modals.newContentElement.Fields.model_listWrapper", [
                "modelIdName" => $modelid,
                "modelName" => "BLAAA",
                "uid" => $model->uid
            ])->render();

            $_top = $modelData["newItemLabel"];
            $_bottom = "";

            if(!isset($modelData["config"]["fields"])) {
                throw new InlineRecordException("CCE - InlineRecord - The fields-configuration for model '$modelid' is missing the property 'config => fields'");
            }

            $fields = $modelData["config"]["fields"];

            foreach($fields as $fieldType => $field) {
                $modelLabel = $field["label"];
                $modelType = $field["type"];

                $modelConfig = $field["config"] ?? [];

                if($modelType == "model") {
                    $modelsHtmlWrapper = view("Centauri::Backend.Modals.newContentElement.Fields.model_control", [
                        "modelType" => $fieldType,
                        "modelTypeParent" => $modelid,
                        "modelLabel" => $modelLabel,
                        "modelCreateNewButtonName" => $field["newItemLabel"] ?? null,
                        "modelFieldKeyName" => $fieldType,
                        "fieldConfiguration" => $field["config"]
                    ])->render();

                    $modelsHtmlWrapper = str_replace("###MODEL_CONTENT###", "", $modelsHtmlWrapper);

                    $_bottom .= $modelsHtmlWrapper;
                } else {
                    $_bottom .= view("Centauri::Backend.Modals.newContentElement.Fields." . $modelType, [
                        "id" => $fieldType,
                        "label" => $modelLabel,
                        "additionalData" => [],
                        "config" => $modelConfig,
                        "isInlineRecord" => true
                    ])->render();
                }
            }

            $html = str_replace("###MODEL_CONTENT_TOP###", $_top, $html);
            $html = str_replace("###MODEL_CONTENT_BOTTOM###", $_bottom, $html);

            return $html;
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
