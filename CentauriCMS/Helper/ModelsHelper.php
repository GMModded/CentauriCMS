<?php
namespace Centauri\CMS\Helper;

class ModelsHelper
{
    /**
     * Returns all CMEs which are registered by extensions and core itself
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

        foreach($extensionsCME as $extModelKey => $extModel) {
            $namespace = $extensionsCME[$extModelKey]["namespace"];
            $tab = $extensionsCME[$extModelKey]["tab"];

            $fields = $extensionsCME[$extModelKey]["fields"];
            $_HTML = "";

            foreach($fields as $fieldKey => $field) {
                $fieldType = $field["type"];
                $fieldLabel = $field["label"];

                $_HTML .= view("Centauri::Backend.Modals.NewContentElement.Fields.$fieldType", [
                    "fieldConfig" => [
                        "uid" => "NEW",
                        "id" => $fieldKey,
                        "label" => $fieldLabel
                    ]
                ])->render();
            }

            $extModel["_HTML"] = $_HTML;
            $extModel["_NAMESPACE"] = $namespace;
            $CME["tabs"][$tab]["models"][$extModelKey] = $extModel;
        }

        $CME["models"] = array_merge($CME["models"], $extensionsCME);

        return $CME;
    }
}