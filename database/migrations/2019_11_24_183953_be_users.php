<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class BeUsers extends Migration
{
    /**
     * Name of this table
     */
    private $table = "be_users";

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
            $table->string("username"),
            $table->string("password"),
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
