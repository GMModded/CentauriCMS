<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriCookies extends Migration
{
    /**
     * Name of this parent-table.
     * 
     * @var string
     */
    private $parentTable = "centauri_cookie_parent";

    /**
     * Name of this child-table.
     * 
     * @var string
     */
    private $childTable = "centauri_cookie_child";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->parentTable, function(Blueprint $table) {
            $table->increments("uid");

            $table->timestamps();
            $table->softDeletes();

            $table->integer("lid");
            $table->integer("hidden");
            $table->integer("sorting")->default(0);

            $table->string("name", 100);
            $table->text("teaser");
            $table->tinyInteger("state")->default(0);
        });

        Schema::create($this->childTable, function(Blueprint $table) {
            $table->increments("uid");

            $table->timestamps();
            $table->softDeletes();

            $table->integer("parent_uid")->nullable();

            $table->integer("lid");
            $table->integer("hidden");
            $table->integer("sorting")->default(0);

            $table->string("name", 100)->nullable();
            $table->text("description")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop($this->parentTable);
        Schema::drop($this->childTable);
    }
}
