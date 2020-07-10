<?php

use Centauri\CMS\Model\Language;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriLanguages extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    private $table = "languages";

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

            $table->string("title");
            $table->string("lang_code", 5);
            $table->string("slug", 50);
            $table->tinyInteger("flagsrc")->nullable();
        });

        $language = new Language;

        $language->title = "English";
        $language->lang_code = "en_US";
        $language->slug = "/";
        $language->flagsrc = 1;

        $language->save();
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
