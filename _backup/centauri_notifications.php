<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Notifications extends Migration
{
    /**
     * Name of this table
     */
    private $table = "notifications";

    /**
     * Columns of this table
     * 
     * @param Blueprint $table
     * 
     * @return void
     */
    private function getColumns($table)
    {
        return [
            $table->increments("uid"),
            $table->string("severity"),
            $table->string("title"),
            $table->text("text"),
            $table->timestamps()
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
                $this->getColumns($table);
            });
        } else {
            Schema::create($this->table, function(Blueprint $table) {
                $this->getColumns($table);
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
