<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Helper\ModelsHelper;
use Illuminate\Http\Request;

class ModelsAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "getModelConfigs") {
            $CMEs = ModelsHelper::getAllCMEs();

            return view("Centauri::Backend.Modals.models", [
                "CME" => $CMEs
            ])->render();
        }

        if($ajaxName == "newModel") {
            $modelClassName = $request->input("model");
            $datas = json_decode($request->input("datas"), true);

            $model = new $modelClassName();
            $model->lid = 0;

            foreach($datas as $data) {
                $id = $data["id"];
                $value = $data["value"];

                $model->$id = $value;
            }

            $CME = config("centauri")["CME"];

            $extensionsCME = $GLOBALS["Centauri"]["Models"];
            foreach($extensionsCME as $extModelKey => $extModel) {
                $fields = $extensionsCME[$extModelKey]["fields"];
                $_HTML = "";

                foreach($fields as $fieldKey => $field) {
                    $fieldType = $field["type"];
                    $fieldLabel = $field["label"];

                    $_HTML .= view("Centauri::Backend.Modals.NewContentElement.Fields.$fieldType", [
                        "fieldConfig" => [
                            "id" => $fieldKey,
                            "label" => $fieldLabel
                        ]
                    ])->render();
                }

                $extensionsCME[$extModelKey]["_HTML"] = $_HTML;
            }

            $CME["models"] = array_merge($CME["models"], $extensionsCME);

            $label = $CME["models"][$modelClassName]["label"];

            if($model->save()) {
                return json_encode([
                    "type" => "success",
                    "title" => "Models - $label",
                    "description" => "This model has been created"
                ]);
            }

            return AjaxAbstract::default($request, $ajaxName);
        }
    }
}
