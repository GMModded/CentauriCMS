<?php
// namespace Centauri\CMS\SQL;

// use Centauri\CMS\Abstracts\SQLAbstract;

// class PagesSQL extends SQLAbstract
// {
//     public function __construct()
//     {
//         $tablename = "pages";

//         $this->setTablename($tablename);
//         $this->setBlueprintTable();

//         $blueprintTable = $this->getBlueprintTable();

//         $this->setColumns([
//             $blueprintTable->increments("uid"),
//             $blueprintTable->integer("pid"),
//             $blueprintTable->integer("lid"),

//             $blueprintTable->timestamps(),
//             $blueprintTable->softDeletes(),

//             $blueprintTable->integer("storage_id"),
//             $blueprintTable->integer("domain_id"),
//             $blueprintTable->integer("dummy"),

//             $blueprintTable->unsignedTinyInteger("hidden"),
//             $blueprintTable->unsignedTinyInteger("hidden_inpagetree"),

//             $blueprintTable->string("backend_layout", 255),
//             $blueprintTable->string("page_type", 255),

//             $blueprintTable->string("seo_keywords", 255),
//             $blueprintTable->string("seo_description", 255),
//             $blueprintTable->unsignedTinyInteger("seo_robots_indexpage", 255),
//             $blueprintTable->unsignedTinyInteger("seo_robots_followpage", 255)
//         ]);

//         // $this->loadSQL();
//     }
// }
