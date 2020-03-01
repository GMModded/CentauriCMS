<?php
namespace Centauri\CMS\AdditionalDatas;

class GridAdditionalDatas implements \Centauri\CMS\AdditionalDataInterface
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

    public function onEditListener($element)
    {
        if(
            is_null($element->grids_rowpos)
        ||
            is_null($element->grids_colpos)
        ) {
            return;
        }
    }
}
