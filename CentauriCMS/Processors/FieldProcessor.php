<?php
namespace Centauri\CMS\Processor;

use Centauri\CMS\Processor;

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
                $value = $element->$elField;

                $fieldType = $field["type"];

                $data = [
                    "element" => $element,
                    "value" => $value
                ];

                if($fieldType == "image") {
                    $element->$elField = ImageProcessor::process($data);
                }

                if($fieldType == "RTE") {
                    $element->$elField = RTEProcessor::process($data);
                }

                if($fieldType == "model") {
                    $element->$elField = InlineProcessor::findByRelation($element->uid, $elField);
                }
            }
        }

        return $element;
    }
}
