<?php
namespace Centauri\CMS\AdditionalDatas;

use Centauri\CMS\Ajax\ContentElementsAjax;
use Centauri\CMS\Centauri;
use Centauri\CMS\Helper\GridHelper;

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

    public function onEditListener($gridelement)
    {
        $gridUid = $gridelement->uid;

        $GridHelper = Centauri::makeInstance(GridHelper::class);
        $elements = $GridHelper->findElementsByGridUid($gridUid);

        $gridLayout = null;

        if(!is_null($gridelement->grid)) {
            $gridLayout = config("centauri")["gridLayouts"][$gridelement->grid] ?? null;
        }

        return response("Grid-Layout '" . $gridelement->grid . "' not found for Grid with ID: " . $gridUid . " in Grid-Layouts configuration", 500);

        return view("Centauri::Backend.Partials.elementsInGrid", [
            "data" => [
                "gridLayout" => $gridLayout,
                "gridelement" => $gridelement,
                "elements" => $elements
            ]
        ])->render();

        if(
            is_null($gridelement->grids_rowpos)
        ||
            is_null($gridelement->grids_colpos)
        ) {
            return;
        }
    }
}
