<?php
namespace Centauri\CMS\Helper;

use Centauri\CMS\Centauri;

class GetModelBySlugHelper
{
    protected static $modelNamespace = "";
    protected static $modelInstance = null;

    public static function setModelnamespace($modelNamespace)
    {
        self::$modelNamespace = $modelNamespace;
        self::$modelInstance = Centauri::makeInstance(self::$modelNamespace);
    }

    public static function getModelnamespace()
    {
        return self::$modelNamespace;
    }

    public static function getModelinstance()
    {
        return self::$modelInstance;
    }

    public static function findBySlug($slug, $columnFieldName = "slug")
    {
        return self::getModelinstance()->where("slug", $slug)->get()->first();
    }
}
