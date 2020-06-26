<?php
namespace Centauri\CMS\Abstracts;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SQLAbstract extends Migration
{
    /**
     * Blueprint object / instance of this table.
     * 
     * @var null|Blueprint
     */
    protected $blueprintTable = null;

    /**
     * Name of this table.
     * 
     * @var string
     */
    protected $tablename = "";

    /**
     * Columns for this table.
     * 
     * @var array
     */
    protected $columns = [];

    /**
     * This method SHOULD BE runned AFTER the class, which extends this abstract one, has setted their tablename and columns.
     * 
     * @return void
     */
    public function loadSQL()
    {
        $tablename = $this->getTablename();

        if($tablename == "") {
            throw new \RuntimeException(
                "SQLAbstract class can't load SQL using an empty tablename!"
            );
        }

        if(is_null($this->getBlueprintTable())) {
            throw new \RuntimeException(
                "SQLAbstract class can't load SQL using a null Blueprint Table!"
            );
        }

        $tableExists = Schema::hasTable($tablename);

        if($tableExists) {
            Schema::table($tablename, function(Blueprint $table) {
                $this->getBlueprintTable()->getColumns();
            });
        } else {
            Schema::create($tablename, function(Blueprint $table) {
                $this->getBlueprintTable()->getColumns();
                // $table->increments("uid");
                // $table->timestamps();
            });
        }
    }

    /**
     * Sets this Blueprint table.
     * 
     * @param string $table This table name.
     * 
     * @return void
     */
    public function setBlueprintTable($table = "")
    {
        if($table == "" && $this->tablename != "") {
            return $this->blueprintTable = new Blueprint($this->getTablename());
        }

        return $this->blueprintTable = new Blueprint($table);
    }

    /**
     * Returns this Blueprint table object.
     * 
     * @return null|Blueprint
     */
    public function getBlueprintTable()
    {
        return $this->blueprintTable;
    }

    /**
     * Sets this tablename.
     * 
     * @param string $tablename Name of this table.
     * 
     * @return void
     */
    public function setTablename($tablename)
    {
        return $this->tablename = $tablename;
    }

    /**
     * Returns this tablename,
     * 
     * @return string
     */
    public function getTablename()
    {
        return $this->tablename;
    }

    /**
     * Sets this columns for this table.
     * 
     * @param array $table This columns.
     * 
     * @return void
     */
    public function setColumns($columns)
    {
        return $this->columns = $columns;
    }

    /**
     * Returns this columns for this table.
     * 
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }
}
