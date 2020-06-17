<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Model\File;

class ImageBladeHelper
{
    public static function get($uid)
    {
        $file = File::where("uid", $uid)->get()->first() ?? false;

        if(!$file) {
            return;
        }

        $file->relativePath = "/storage/Centauri/Filelist/" . $file->name;
        return $file;
    }

    public static function getPath($uid)
    {
        $file = self::get($uid);

        if(!$file) {
            return;
        }

        return $file->relativePath;
    }
}
