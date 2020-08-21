<?php
namespace Centauri\CMS\Processor;

use Centauri\CMS\Model\FileReference;
use Illuminate\Support\Str;

class ImageProcessor
{
    public static function process($data)
    {
        $value = $data["value"];

        if(Str::contains($value, ",")) {
            $value = explode(",", $value);
        } else {
            $value = [$value];
        }

        $fileReferences = FileReference::where("uid_element", $data["element"]->uid)->get()->all();

        // dd($fileReferences);

        $data["element"]->html = view("Centauri::Frontend.Templates.image", [
            "fileReferences" => $fileReferences
        ])->render();

        return $data;
    }
}
