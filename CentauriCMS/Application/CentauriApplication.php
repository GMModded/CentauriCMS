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
            "Extensions" => [],

            "Models" => [],
            "Plugins" => [],

            "Processors" => [
                "__before" => [],
                "__after" => []
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
