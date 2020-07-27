<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriFiles extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    protected $table = "files";

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

            $table->string("name");
            $table->string("path");
            $table->tinyInteger("cropable");
            $table->string("type", 15);
        });
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
