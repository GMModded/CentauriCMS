<?php
namespace Centauri\CMS\SQL;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SchedulersSQL extends Migration
{
    /**
     * Name of this table
     */
    private $table = "schedulers";

    /**
     * Preparation of columns for this migrations' table.
     * 
     * @return void
     */
    private function cols($table)
    {
        return [
            $table->increments("uid"),

            $table->timestamps(),
            $table->softDeletes(),

            $table->string("name", 255),
            $table->string("namespace", 255),
            $table->tinyInteger("state"),
            $table->string("last_runned", 255),
            $table->string("time", 255)
        ];
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableExists = Schema::hasTable($this->table);

        if($tableExists) {
            Schema::table($this->table, function(Blueprint $table) {
                $this->cols($table);
            });
        } else {
            Schema::create($this->table, function(Blueprint $table) {
                $this->cols($table);
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
