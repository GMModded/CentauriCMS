<?php
namespace Centauri\CMS\Application;

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
                            \Centauri\CMS\AdditionalDatas\HeadTagAdditionalDatas::class
                        ]
                    ]
                ],

                "ContentElements" => [
                    "plugin" => [
                        "class" => \Centauri\CMS\AdditionalDatas\PluginAdditionalDatas::class
                    ],

                    "grid" => [
                        "class" => \Centauri\CMS\AdditionalDatas\GridAdditionalDatas::class,
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
                "pageNotFound" => [
                    "config" => [
                        "__DEFAULT__" => \Centauri\CMS\Http\PageNotFound::class
                    ]
                ],

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
