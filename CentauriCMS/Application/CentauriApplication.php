<?php
namespace Centauri\CMS\Application;

use \Centauri\CMS\AdditionalDatas;

class CentauriApplication
{
    public $Centauri;

    public function __construct()
    {
        $this->Centauri = [
            "Modules" => [],

            "ContentElements" => [],
            "AdditionalDataFuncs" => [
                "Frontend" => [
                    "Tags" => [
                        "Head" => [
                            AdditionalDatas\HeadTagAdditionalDatas::class
                        ]
                    ]
                ],

                "ContentElements" => [
                    "plugin" => [
                        "class" => AdditionalDatas\PluginAdditionalDatas::class
                    ],

                    "grid" => [
                        "class" => AdditionalDatas\GridAdditionalDatas::class,
                        "return_statement" => 1
                    ]
                ]
            ],

            "Extensions" => [],

            "Models" => [],
            "Plugins" => [],

            "Processors" => [
                "__before" => [],
                "__after" => []
            ],

            "Handlers" => [
                "pageNotFound" => \Centauri\CMS\Http\PageNotFound::class,

                // Extendable by extensions
                "routes" => []
            ],

            "Helper" => [
                "VariablesHelper" => [
                    "__ContentElementsAjax__IteratorForFields" => 0
                ]
            ],

            "Hooks" => [],

            "Paths" => [
                "BaseURL" => ""
            ]
        ];

        return $this->Centauri;
    }
}
