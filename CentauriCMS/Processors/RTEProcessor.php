<?php
namespace Centauri\CMS\Processor;

use Illuminate\Support\Str;

class RTEProcessor
{
    public static function process($data)
    {
        $value = $data["value"];
        return $value;
        $exploded = explode(" ", $value);

        $i = 0;
        $colorCssCode = "";

        foreach($exploded as $key => $item) {
            if(Str::contains($item, "style")) {
                $val = str_replace('style="', "", $item);
                $stylesStr = explode('">', $val)[0];

                $property = explode(":", $stylesStr)[0];
                $value = explode(":", $stylesStr)[1];

                if(Str::contains($value, ";")) {
                    $value = explode(";", $value)[0];
                }

                if($property == "text-align") {
                    $property = "text-" . $value;
                }
                if($property == "display") {
                    $property = "d-" . $value;
                }

                $class = "";

                if(Str::contains($property, "color")) {
                    $class = $property . "-" . $i;
                    $colorCssCode .= "." . $class . " {\n    " . $property . ": " . $value . ";\n}\n\n";
                }

                if($class == "") {
                    $class = str_replace(";", "", $property);
                }

                $i++;
            }
        }

        return $data["value"];
    }
}
