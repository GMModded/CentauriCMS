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

        $gridConfig = null;

        if(!is_null($gridelement->grid)) {
            $gridConfig = config("centauri")["gridLayouts"][$gridelement->grid] ?? null;
        } else {
            return response("Grid-Layout '" . $gridelement->grid . "' not found for Grid with ID: " . $gridUid . " in Grid-Layouts configuration", 500);
        }

        $data = [
            "data" => [
                "gridConfig" => $gridConfig,
                "gridelement" => $gridelement,
                "elements" => $elements
            ]
        ];

        return view("Centauri::Backend.Partials.elementsInGrid", $data)->render();

        // if(
        //     is_null($gridelement->grids_rowpos)
        // ||
        //     is_null($gridelement->grids_colpos)
        // ) {
        //     return;
        // }
    }
}
