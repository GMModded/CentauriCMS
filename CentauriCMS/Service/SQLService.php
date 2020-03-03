<?php
namespace Centauri\CMS\Service;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SQLService
{
    public function createTable($table)
    {
        if(Schema::hasTable($table)) {
            return false;
        }

        Schema::create($table, function(Blueprint $table) {
            $table->timestamps();
            $table->softDeletes();
            $table->increments("uid");
            $table->integer("lid");
            $table->integer("parent_uid");
            $table->integer("sorting");
        });

        return true;
    }

    public function createColumn($table, $column, $type, $options = [])
    {
        $_options = [];

        if(!empty($options)) {
            $_options = $options;
        }

        if(Schema::hasColumn($table, $column)) {
            return false;
        }

        Schema::table($table, function($table) use($type, $column, $options) {
            if(!isset($options["default"])) {
                if(!isset($options["nullable"])) {
                    $table->$type($column);
                } else {
                    $table->$type($column)->nullable();
                }
            } else {
                if(!isset($options["nullable"])) {
                    $table->$type($column)->default($options["default"]);
                } else {
                    $table->$type($column)->default($options["default"])->nullable();
                }
            }
        });

        return true;
    }
}
