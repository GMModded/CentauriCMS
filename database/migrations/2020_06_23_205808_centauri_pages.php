<?php

use Centauri\CMS\Model\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CentauriPages extends Migration
{
    /**
     * Name of this table.
     * 
     * @var string
     */
    private $table = "pages";

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

            $table->tinyInteger("pid")->default(0);
            $table->tinyInteger("lid")->default(0);
            $table->string("backend_layout")->default("default");
            $table->string("title");
            $table->string("slugs");
            $table->tinyInteger("hidden")->default(0);
            $table->string("seo_keywords")->default("");
            $table->string("seo_description")->default("");
            $table->tinyInteger("seo_robots_indexpage")->default(0);
            $table->tinyInteger("seo_robots_followpage")->default(0);
            $table->tinyInteger("hidden_inpagetree")->default(0);
            $table->string("page_type")->default("rootpage");
            $table->tinyInteger("storage_id")->default(null)->nullable();
            $table->tinyInteger("domain_id")->default(null)->nullable();
        });

        $page = new Page;

        $page->lid = 1;
        $page->title = "Home";
        $page->slugs = "/";
        $page->page_type = "rootpage";

        $page->save();
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
