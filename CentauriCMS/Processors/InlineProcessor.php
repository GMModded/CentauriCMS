<?php
namespace Centauri\CMS\Processor;

class InlineProcessor
{
    public static function findByRelation($parent_uid, $tablename, $model)
    {
        $records = $model::where([
            "parent_uid" => $parent_uid,
            "hidden" => 0
        ])->orderBy("sorting", "asc")->get()->all();

        return $records;
    }
}
