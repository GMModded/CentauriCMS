<?php
namespace Centauri\CMS\Application;

use Centauri\CMS\Utility\PathUtility;

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
                "VariablesHelper" => []
            ],

            "Hooks" => [],

            "Paths" => [
                "BaseURL" => ""
            ]
        ];

        return $this->Centauri;
    }
}
