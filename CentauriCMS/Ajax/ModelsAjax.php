<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Helper\ModelsHelper;
use Centauri\CMS\Traits\AjaxTrait;
use Illuminate\Http\Request;

class ModelsAjax
{
    use AjaxTrait;

    /**
     * Returns all CMEs Model-Configs.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function getModelConfigsAjax(Request $request)
    {
        $CMEs = ModelsHelper::getAllCMEs();

        return view("Centauri::Backend.Modals.models", [
            "CME" => $CMEs
        ])->render();
    }

    /**
     * Record creation of a new model.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function newModelAjax(Request $request)
    {
        $modelClassName = $request->input("model");
        $datas = json_decode($request->input("datas"), true);

        $model = new $modelClassName();
        $model->lid = 1;

        foreach($datas as $data) {
            foreach($data as $uid => $dataArr) {
                foreach($dataArr as $id => $fieldArr) {
                    $value = $fieldArr["value"];
                    $model->$id = $value;
                }
            }
        }

        $CME = config("centauri")["CME"];
        $extensionsCME = $GLOBALS["Centauri"]["Models"];

        foreach($extensionsCME as $extModelKey => $extModel) {
            $fields = $extensionsCME[$extModelKey]["fields"] ?? ($extensionsCME[$extModelKey]["config"]["fields"] ?? []);
            $_HTML = "";

            foreach($fields as $fieldKey => $field) {
                $fieldType = $field["type"];
                $fieldLabel = $field["label"];

                if($fieldType != "model") {
                    $_HTML .= view("Centauri::Backend.Modals.NewContentElement.Fields.$fieldType", [
                        "fieldConfig" => [
                            "uid" => "NEW",
                            "id" => $fieldKey,
                            "label" => $fieldLabel
                        ]
                    ])->render();
                }
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
    }
}
