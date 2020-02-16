<?php
namespace Centauri\CMS\Helper;

use Centauri\CMS\Ajax\ContentElementsAjax;
use Centauri\CMS\Centauri;

class ContentElementBEHelper
{
    public static function getModelWrapperHTML($field, $models)
    {
        $ContentElementAjaxClass = Centauri::makeInstance(ContentElementsAjax::class);

        $html = view("Centauri::Backend.Modals.NewContentElement.Fields.model_control", [
            "label" => $field["label"],
            "createNewButton" => $field["newItemLabel"] ?? null
        ])->render();

        $modelsHtml = "";
        foreach($models as $model) {
            $modelHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
                "uid" => $model->uid
            ])->render();

            $bottomHtml = "";

            if($field["type"] == "model") {
                foreach($field["config"]["fields"] as $key => $_field) {
                    if($_field["type"] == "model") {
                        $modelWrapper = view("Centauri::Backend.Modals.NewContentElement.Fields.model_control", [
                            "label" => $_field["label"],
                            "createNewButton" => $_field["newItemLabel"] ?? null
                        ])->render();

                        $_html = "";
                        dump($models);
                        foreach($_field["config"]["fields"] as $_key => $__field) {
                            // $_html .= $ContentElementAjaxClass->renderSingleField($__field, $_key, $model);
                        }

                        $bottomHtml .= str_replace("###MODELS###", $_html, $modelWrapper);
                    }

                    $bottomHtml .= $ContentElementAjaxClass->renderSingleField($_field, $key, $model);
                }
            }

            $existingLabel = $field["existingItemLabel"] ?? "";

            $modelHtml = str_replace("###MODEL_CONTENT_TOP###", $model->$existingLabel, $modelHtml);
            $modelHtml = str_replace("###MODEL_CONTENT_BOTTOM###", $bottomHtml, $modelHtml);

            $modelsHtml .= $modelHtml;
        }

        $html = str_replace("###MODELS###", $modelsHtml, $html);

        return $html;
    }
}
