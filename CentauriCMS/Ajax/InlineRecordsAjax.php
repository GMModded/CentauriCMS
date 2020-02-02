<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\File;
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
            $modelid = $request->input("name");

            $CCE = config("centauri")["CCE"];
            $modelField = $CCE["fields"][$modelid];

            $model = new $modelField["config"]["model"];
            $model->setAttribute("parent_uid", 5);
            $model->setAttribute("sorting", 1);
            $model->save();

            $html = view("Centauri::Backend.Modals.newContentElement.Fields.model_listWrapper", [
                "modelName" => $modelid,
                "uid" => $model->uid
            ])->render();

            $_top = $modelField["newItemLabel"];
            $_bottom = "";

            $fields = $modelField["config"]["fields"];

            foreach($fields as $fieldType => $field) {
                $modelLabel = $field["label"];
                $modelType = $field["type"];

                $modelConfig = $field["config"] ?? [];

                $_bottom .= view("Centauri::Backend.Modals.newContentElement.Fields." . $modelType, [
                    "id" => $fieldType,
                    "label" => $modelLabel,
                    "additionalData" => [],
                    "config" => $modelConfig,
                    "isInlineRecord" => true
                ])->render();
            }

            $html = str_replace("###MODEL_CONTENT_TOP###", $_top, $html);
            $html = str_replace("###MODEL_CONTENT_BOTTOM###", $_bottom, $html);

            return $html;
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
