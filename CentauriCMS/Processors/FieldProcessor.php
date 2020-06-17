<?php
namespace Centauri\CMS\Processor;

use Centauri\CMS\Helper\CCEHelper;
use Illuminate\Support\Str;

class FieldProcessor
{
    public static function process($element, $data, $paramElFields = null)
    {
        $fields = CCEHelper::getAllFields();
        $elements = CCEHelper::getAllElements();

        $elFields = (is_null($paramElFields) ? $elements[$element->ctype] : dd("LOL", $paramElFields));

        foreach($elFields as $key => $elField) {
            $_ = null;

            if(is_array($elField)) {
                $_ = $key;
            } else {
                $_ = $elField;
            }

            if(Str::contains($_, ";")) {
                $splitted_ = explode(";", $_);
            } else {
                if(isset($fields[$_])) {
                    $field = $fields[$_];
                    $value = $element->$_;

                    $fieldType = isset($field["type"]) ? $field["type"] : "";

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

                    if($fieldType == "model" && isset($field["config"]) && isset($field["config"]["model"])) {
                        $element->$_ = InlineProcessor::findByRelation($element->uid, $_, $field["config"]["model"]);
                    }

                    if(Str::startsWith($_, "grid")) {
                        $element->$_ = GridsProcessor::process($data);
                    }
                }
            }
        }

        return $element;
    }
}
