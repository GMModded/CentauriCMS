<?php
namespace Centauri\CMS\AdditionalDatas;

use Centauri\CMS\Centauri;
use Centauri\CMS\Helper\GridHelper;

class GridAdditionalDatas implements \Centauri\CMS\Interfaces\AdditionalDataInterface
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
        $GridHelper = Centauri::makeInstance(GridHelper::class);

        $gridUid = $gridelement->uid;
        $gridConfig = null;

        if(!is_null($gridelement->grid)) {
            $gridConfig = config("centauri")["gridLayouts"][$gridelement->grid] ?? null;
        } else {
            return response("Grid-Layout '" . $gridelement->grid . "' not found for Grid with UID: " . $gridUid . " in Grid-Layouts configuration", 500);
        }

        $elements = [];

        foreach($gridConfig["config"] as $rowPos => $rowArr) {
            foreach($rowArr["cols"] as $colPos => $colArr) {
                $elements[$colPos] = [
                    "colData" => $colArr,
                    "elements" => $GridHelper->findElementsByGridUid($gridUid, 1, $rowPos, $colPos)
                ];
            }
        }

        $data = [
            "data" => [
                "gridConfig" => $gridConfig,
                "gridelement" => $gridelement,
                "elements" => $elements
            ]
        ];

        return view("Centauri::Backend.Partials.elementsInGrid", $data)->render();
    }
}
