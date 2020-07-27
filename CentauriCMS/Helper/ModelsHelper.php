<?php
namespace Centauri\CMS\Helper;

use Centauri\CMS\Ajax\ContentElementsAjax;
use Centauri\CMS\Centauri;

class ModelsHelper
{
    /**
     * Returns all CMEs which are registered by extensions and core itself.
     * 
     * @return array
     */
    public static function getAllCMEs()
    {
        $CME = config("centauri")["CME"];
        $models = $CME["models"];

        foreach($models as $key => $model) {
            $fields = $models[$key]["fields"];
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

            $models[$key]["_HTML"] = $_HTML;
            $models[$key]["_NAMESPACE"] = "Centauri";
        }

        $CME["models"] = $models;
        $extensionsCME = $GLOBALS["Centauri"]["Models"];

        $ContentElementsAjax = Centauri::makeInstance(ContentElementsAjax::class);

        $extensionsCME = array_filter($extensionsCME, function($modelItem) {
            if(isset($modelItem["isChild"]) && (!($modelItem["isChild"])) || !isset($modelItem["isChild"])) {
                return $modelItem;
            }
        });

        foreach($extensionsCME as $extModelKey => $extModel) {
            $namespace = $extensionsCME[$extModelKey]["namespace"];
            $tab = $extensionsCME[$extModelKey]["tab"];

            $fields = $extensionsCME[$extModelKey]["fields"];
            $_HTML = "";

            foreach($fields as $fieldKey => $field) {
                $fieldType = $field["type"];
                $fieldLabel = $field["label"];

                $html = "";

                if($fieldType == "model") {
                    $modelConfig = $GLOBALS["Centauri"]["Models"][$field["config"]["model"]] ?? null;

                    $modelWrapper = view("Centauri::Backend.Modals.NewContentElement.Fields.model_control", [
                        "modelType" => $modelConfig["namespace"],
                        "modelTypeParent" => $extModel["namespace"],
                        "modelLabel" => $modelConfig["label"],
                        "modelCreateNewButtonName" => $modelConfig["newItemLabel"] ?? null,
                        "modelParentUid" => "NEW",
                        "namespace" => $namespace,
                        "noModelContent" => 1
                    ])->render();

                    $modelsHtml = "";

                    $modelNamespace = $field["config"]["model"];

                    $modelInstance = new $modelNamespace;
                    $models = $modelInstance::orderBy("sorting", "ASC")->get()->all();

                    foreach($models ?? [] as $model) {
                        $_modelsHtml = view("Centauri::Backend.Modals.NewContentElement.Fields.model_singleitem", [
                            "model" => $model
                        ])->render();

                        $existingItemLabel = $field["existingItemLabel"];
                        $top = $model->$existingItemLabel ?? $field["listLabel"] ?? "Item";

                        $bottom = "";

                        foreach($field["config"]["fields"] as $_key => $_field) {
                            $bottom .= $ContentElementsAjax->renderField((is_int($_key) ? $_field : $_key), $model, $modelNamespace);
                        }

                        $splittedTop = explode(" ", $top);
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
                            $nSpittedTop = $field["listLabel"];
                        }

                        $_modelsHtml = str_replace("###MODEL_CONTENT_TOP###", $nSpittedTop, $_modelsHtml);
                        $_modelsHtml = str_replace("###MODEL_CONTENT_BOTTOM###", $bottom, $_modelsHtml);

                        $modelsHtml .= $_modelsHtml;
                    }

                    $html = str_replace("###MODEL_CONTENT###", $modelsHtml, $modelWrapper);
                } else {
                    $html = view("Centauri::Backend.Modals.NewContentElement.Fields.$fieldType", [
                        "fieldConfig" => [
                            "uid" => "NEW",
                            "id" => $fieldKey,
                            "label" => $fieldLabel
                        ]
                    ])->render();
                }

                $_HTML .= $html;
            }

            $extModel["_HTML"] = $_HTML;
            $extModel["_NAMESPACE"] = $namespace;
            $CME["tabs"][$tab]["models"][$extModelKey] = $extModel;
        }

        $CME["models"] = array_merge($CME["models"], $extensionsCME);

        return $CME;
    }
}