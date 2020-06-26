<?php
// namespace Centauri\CMS\SQL;

// use Centauri\CMS\Abstracts\SQLAbstract;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class TestSQL extends SQLAbstract
// {
//     protected $sqlTableName = "test";

//     public function __construct()
//     {
//         $this->setTablename($this->sqlTableName);
//         $this->setBlueprintTable($this->getTablename());
        
//         $blueprintTable = $this->getBlueprintTable();
        
//         $this->setColumns([
//             $blueprintTable->increments("uid"),
//             $blueprintTable->integer("pid")
//         ]);

//         $this->setColumns([
            
//         ]);

//         $this->loadSQL();
//     }
// }
