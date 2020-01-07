<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Model\File;

class ImageBladeHelper
{
    public static function get($uid)
    {
        return File::where("uid", $uid)->get()->first() ?? false;
    }

    public static function getPath($uid)
    {
        return File::where("uid", $uid)->get()->first()->path ?? false;
    }
}
