<?php
namespace Centauri\CMS\Processor;

class FieldProcessor
{
    public static function process($element, $data)
    {
        $CCE = config("centauri")["CCE"];
        $fields = $CCE["fields"];
        $elFields = $CCE["elements"][$element->ctype];

        foreach($elFields as $elField) {
            if(isset($fields[$elField])) {
                $field = $fields[$elField];

                if($field["type"] == "image") {
                    $value = $element->$elField;

                    $element->$elField = \Centauri\CMS\Processor\ImageProcessor::process([
                        "element" => $element,
                        "value" => $value
                    ]);
                }
            }
        }

        return $element;
    }
}
