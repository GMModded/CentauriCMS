<?php
namespace Centauri\CMS\SQL;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ElementsSQL extends Migration
{
    /**
     * Name of this table
     */
    private $table = "elements";

    public function __construct()
    {
        dd("OSDGN");
    }

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

            $table->integer("rowPos"),
            $table->integer("colPos"),

            $table->integer("hidden"),
            $table->integer("sorting"),

            $table->string("ctype", 255),
            $table->string("plugin", 255),

            $table->integer("file"),

            $table->string("grid", 50),
            $table->integer("grids_parent"),
            $table->integer("grids_sorting_rowpos"),
            $table->integer("grids_sorting_colpos"),
            $table->string("grid_config"),
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
}
