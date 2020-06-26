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
            $table->integer("sorting");
            $table->string("ctype");

            $table->string("image")->nullable();
            $table->string("file")->nullable();
            $table->string("plugin")->nullable();

            $table->tinyInteger("grids_sorting_rowpos")->nullable();
            $table->tinyInteger("grids_sorting_colpos")->nullable();

            $table->integer("hidden");
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
