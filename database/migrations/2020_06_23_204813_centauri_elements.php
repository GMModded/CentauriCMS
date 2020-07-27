<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriElements extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    private $table = "elements";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function(Blueprint $table) {
            $table->increments("uid");

            $table->timestamps();
            $table->softDeletes();

            $table->integer("pid");
            $table->integer("lid");
            $table->integer("rowPos");
            $table->integer("colPos");
            $table->integer("hidden");
            $table->integer("sorting");
            $table->string("ctype");

            $table->string("image")->nullable();
            $table->string("file")->nullable();
            $table->string("plugin")->nullable();

            $table->string("htag")->nullable();
            $table->string("header")->nullable();
            $table->string("subheader")->nullable();
            $table->longText("RTE")->nullable();

            $table->string("grid")->nullable();
            $table->string("grid_fullsize")->nullable();
            $table->string("grid_space_top")->nullable();
            $table->string("grid_space_bottom")->nullable();
            $table->integer("grids_parent")->nullable();
            $table->integer("grids_sorting_rowpos")->nullable();
            $table->integer("grids_sorting_colpos")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->table);
    }
}
