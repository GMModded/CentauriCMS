<?php
namespace Centauri\CMS\Processor;

use Illuminate\Support\Str;

class ImageProcessor
{
    public static function process($data)
    {
        $value = $data["value"];
        return $value;

        if(Str::contains($value, ",")) {
            $value = explode(",", $value);
        } else {
            $value = [$value];
        }

        return $value;
    }
}
