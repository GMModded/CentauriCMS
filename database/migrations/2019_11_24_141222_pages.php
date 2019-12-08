<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Pages extends Migration
{
    /**
     * Name of this table
     */
    private $table = "pages";

    /**
     * Columns of this table
     * 
     * @param string $table
     * 
     * @return void
     */
    private function cols($table)
    {
        return [
            $table->increments("uid"),
            $table->integer("pid"),
            $table->integer("lid"),
            $table->integer("backend_layout"),
            $table->integer("is_rootpage"),
            $table->string("title"),
            $table->text("slugs"),
            $table->timestamps(),
            $table->softDeletes()
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
