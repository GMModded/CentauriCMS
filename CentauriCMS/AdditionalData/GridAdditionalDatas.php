<?php
namespace Centauri\CMS\AdditionalDatas;

class GridAdditionalDatas
{
    public function fetch()
    {
        return [
            "grids" => [
                "One-Column Container" => "onecol",
                "Two-Column Container" => "twocol",
                "Three-Column Container" => "threecol",
                "Four-Column Container" => "fourcol"
            ]
        ];
    }
}
