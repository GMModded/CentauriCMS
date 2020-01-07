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
                "VariablesHelper" => []
            ],

            "Hooks" => []
        ];

        return $this->Centauri;
    }
}
