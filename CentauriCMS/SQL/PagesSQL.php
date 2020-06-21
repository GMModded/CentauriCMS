<?php
namespace Centauri\CMS\SQL;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PagesSQL extends Migration
{
    /**
     * Name of this table
     */
    private $table = "pages";

    /**
     * Preparation of columns for this migrations' table.
     * 
     * @return void
     */
    private function cols($table)
    {
        return [
            $table->increments("uid"),
            $table->integer("pid"),
            $table->integer("lid"),

            $table->timestamps(),
            $table->softDeletes(),

            $table->integer("storage_id"),
            $table->integer("domain_id"),

            $table->unsignedTinyInteger("hidden"),
            $table->unsignedTinyInteger("hidden_inpagetree"),

            $table->string("backend_layout", 255),
            $table->string("page_type", 255),

            $table->string("seo_keywords", 255),
            $table->string("seo_description", 255),
            $table->unsignedTinyInteger("seo_robots_indexpage", 255),
            $table->unsignedTinyInteger("seo_robots_followpage", 255)
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
