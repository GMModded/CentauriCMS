<?php
namespace Centauri\CMS\Processor;

use Illuminate\Support\Facades\DB;

class InlineProcessor
{
    public static function findByRelation($parent_uid, $tablename)
    {
        return DB::table($tablename)->where("parent_uid", $parent_uid)->get()->all();
    }
}
