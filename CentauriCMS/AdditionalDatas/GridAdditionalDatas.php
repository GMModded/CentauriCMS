<?php
namespace Centauri\CMS\AdditionalDatas;

use Centauri\CMS\Ajax\ContentElementsAjax;
use Centauri\CMS\Centauri;
use Centauri\CMS\Helper\GridHelper;

class GridAdditionalDatas
{
    /**
     * This fetch-method will be used inside the core for AdditionalDatas.
     * 
     * @return array
     */
    public function fetch()
    {
        $gridLayouts = config("centauri")["gridLayouts"];

        return [
            "grids" => [
                "One-Column Container" => [
                    "config" => $gridLayouts["onecol"]["gridFieldsConfig"] ?? []
                ],

                "Two-Column Container" => [
                    "config" => $gridLayouts["twocol"]["gridFieldsConfig"] ?? []
                ],

                "Three-Column Container" => [
                    "config" => $gridLayouts["threecol"]["gridFieldsConfig"] ?? []
                ],

                "Four-Column Container" => [
                    "config" => $gridLayouts["fourcol"]["gridFieldsConfig"] ?? []
                ]
            ]
        ];
    }

    /**
     * Edit-Listener - called whenever this additional-data-type element gets edited in the BE.
     * 
     * @param object $gridelement
     * 
     * @return string|void
     */
    public function onEditListener(object $gridelement)
    {
        $GridHelper = Centauri::makeInstance(GridHelper::class);

        $gridUid = $gridelement->uid;
        $gridConfig = null;

        if(!is_null($gridelement->grid)) {
            $gridConfig = config("centauri")["gridLayouts"][$gridelement->grid] ?? null;
        } else {
            return Centauri::throwStaticException("Grid-Layout '" . $gridelement->grid . "' not found for Grid with UID: " . $gridUid . " in Grid-Layouts configuration");
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

    public function getAdditionalData($data)
    {
        $gridelement = $data["element"];

        if(is_null($gridelement)) {
            return;
        }

        $gridUid = $gridelement->uid;
        $gridConfig = null;

        if(!is_null($gridelement->grid)) {
            $gridConfig = config("centauri")["gridLayouts"][$gridelement->grid] ?? null;
        } else {
            return Centauri::throwStaticException("Grid-Layout '" . $gridelement->grid . "' not found for Grid with UID: " . $gridUid . " in Grid-Layouts configuration");
        }
        
        $cfgHtml = "";
        $ContentElementsAjax = Centauri::makeInstance(ContentElementsAjax::class);

        foreach($gridConfig["gridFieldsConfig"] ?? [] as $field) {
            $cfgHtml .= $ContentElementsAjax->renderField($field, $gridelement);
        }

        $data = $this->onEditListener($gridelement);

        return [
            "elementsInGridHTML" => $data,
            "gridConfigHTML" => $cfgHtml
        ];
    }

    public function findFieldsByUid($data)
    {
        $gridelement = $data["element"];

        $gridUid = $gridelement->uid;
        $gridConfig = null;

        if(!is_null($gridelement->grid)) {
            $gridConfig = config("centauri")["gridLayouts"][$gridelement->grid] ?? null;
        } else {
            return Centauri::throwStaticException("Grid-Layout '" . $gridelement->grid . "' not found for Grid with UID: " . $gridUid . " in Grid-Layouts configuration");
        }

        $cfgHtml = "";
        $ContentElementsAjax = Centauri::makeInstance(ContentElementsAjax::class);

        foreach($gridConfig["gridFieldsConfig"] ?? [] as $field) {
            $cfgHtml .= $ContentElementsAjax->renderField($field, $gridelement);
        }

        $data = $this->onEditListener($gridelement);

        return view("Centauri::Backend.Modals.NewContentElement.Fields.AdditionalTypes.grid", [
            "additionalData" => [
                "elementsInGridHTML" => $data,
                "gridConfigHTML" => $cfgHtml
            ]
        ])->render();
    }
}
