<?php
namespace Centauri\CMS\Processor;

use Illuminate\Support\Str;

class FieldProcessor
{
    public static function process($element, $data, $paramElFields = null)
    {
        $CCE = config("centauri")["CCE"];
        $fields = $CCE["fields"];
        $elFields = (is_null($paramElFields) ? $CCE["elements"][$element->ctype] : dd($paramElFields));

        foreach($elFields as $key => $elField) {
            $_ = null;

            if(is_array($elField)) {
                $_ = $key;
            } else {
                $_ = $elField;
            }

            if(isset($fields[$_])) {
                $field = $fields[$_];
                $value = $element->$_;

                $fieldType = $field["type"];

                $data = [
                    "element" => $element,
                    "value" => $value
                ];

                if($fieldType == "image") {
                    $element->$_ = ImageProcessor::process($data);
                }

                if($fieldType == "RTE") {
                    $element->$_ = RTEProcessor::process($data);
                }

                if($fieldType == "model") {
                    $element->$_ = InlineProcessor::findByRelation($element->uid, $_, $field["config"]["model"]);
                }

                if(Str::startsWith($_, "grid")) {
                    $element->$_ = GridsProcessor::process($data);
                }
            }
        }

        return $element;
    }
}
