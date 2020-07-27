<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FilesReference extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    protected $table = "files_reference";

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

            $table->integer("uid_element");
            $table->integer("uid_image");

            $table->string("fieldname");
            $table->string("tablename");

            $table->string("title")->nullable();
            $table->string("alt")->nullable();
            $table->text("description")->nullable();
            $table->binary("data")->nullable();
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
