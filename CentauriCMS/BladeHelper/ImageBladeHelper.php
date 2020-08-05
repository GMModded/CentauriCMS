<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Model\File;
use Centauri\CMS\Model\FileReference;

class ImageBladeHelper
{
    public static function get($uid)
    {
        return;
        $fileReference = FileReference::where("uid", $uid)->get()->first() ?? false;

        if(is_null($fileReference)) {
            return null;
        }

        // dd($fileReference);

        $fileReference->relativePath = "/storage/Centauri/Filelist/" . $file->name;
        return $file;
    }

    public static function getPath($uid)
    {
        $file = \Centauri\CMS\Model\File::where("uid", $uid)->get()->first();
        $file->relativePath = "/storage/Centauri/Filelist/" . $file->name;

        /*
        if(is_array($uid)) {
            $files = [];

            foreach($uid as $id) {
                $files[] = self::get($id)->relativePath ?? null;
            }

            if(sizeof($files) == 1) {
                return $files[0];
            }

            return $files;
        }

        $file = self::get($uid);

        if(!$file) {
            return "Couldn't get the path of image with uid '$uid'";
        }*/

        return $file->relativePath;
    }

    public static function findReferenceByElement($element)
    {
        foreach($element->image as $imageUid) {
            $fileReference = FileReference::where([
                "uid_image" => $imageUid,
                "uid_element" => $element->uid
            ])->get()->first();

            dd($fileReference, $imageUid);
        }
    }

    public static function findPathByView($fileReference, $view)
    {
        if($view == "default") {
            $view = "";
        } else {
            $view .= "_";
        }

        $file = File::where("uid", $fileReference->uid_image)->get()->first();

        $file->path = str_replace("cropped/", "", $file->path);

        $croppedImageViewPath = dirname($file->path) . "/Filelist/cropped/" . $view . $file->name;
        // dd($croppedImageViewPath);

        return $croppedImageViewPath;
    }
}
