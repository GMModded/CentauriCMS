<?php
namespace Centauri\CMS\Processor;

use Illuminate\Support\Facades\DB;

class InlineProcessor
{
    public static $excludedFields = [
        "uid",
        "parent_uid",
        "pid",
        "lid",

        "rowPos",
        "colPos",
        "sorting",
        "ctype",

        "created_at",
        "updated_at",
        "deleted_at"
    ];

    public static function findByRelation($parent_uid, $tablename, $model)
    {
        $relations = $model::where("parent_uid", $parent_uid)->get()->all();

        // foreach($relations as $relation) {
        //     foreach($relation->getAttributes() as $attrKey => $attrVal) {
        //         if(!in_array($attrKey, self::$excludedFields) && is_int($attrVal) && method_exists($model, $attrKey)) {
        //             $relation->$attrKey = $relation->$attrKey();
        //         }
        //     }
        // }

        return $relations;
    }
}
