<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriSchedulers extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    private $table = "schedulers";

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
            $table->string("namespace");
            $table->string("last_runned")->default("-");
            $table->string("time")->default("hourly");
            $table->string("state")->default("CREATED");
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
