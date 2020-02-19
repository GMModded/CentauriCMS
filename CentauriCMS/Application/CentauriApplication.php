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
                "ContentElements" => [
                    "plugin" => \Centauri\CMS\AdditionalDatas\PluginAdditionalDatas::class,
                    "grid" => \Centauri\CMS\AdditionalDatas\GridAdditionalDatas::class
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
                ]
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
