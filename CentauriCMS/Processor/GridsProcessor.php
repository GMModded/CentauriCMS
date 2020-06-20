<?php
namespace Centauri\CMS\Processor;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Helper\GridHelper;
use Exception;

class GridsProcessor
{
    public static function process($data)
    {
        $GridHelper = Centauri::makeInstance(GridHelper::class);

        $gridUid = $data["element"]->uid;
        $elements = $GridHelper->findElementsByGridUid($gridUid, 1);

        $ElementComponent = Centauri::makeInstance(ElementComponent::class);

        $renderedHTML = "";
        $renderedColsHTML = [];

        $value = $data["value"];
        $gridLayout = config("centauri")["gridLayouts"][$value] ?? null;

        if(is_null($gridLayout)) {
            throw new Exception("Grid-Layout '" . $value . "' not found!");
        }

        $elements = [];
        $renderedColsHTML = [];

        foreach($gridLayout["config"] as $rowPos => $rowArr) {
            foreach($rowArr["cols"] as $colPos => $colArr) {
                if(!isset($elements[$rowPos])) {
                    $elements[$rowPos] = [
                        $colPos => $GridHelper->findElementsByGridUid($gridUid, 1, $rowPos, $colPos)
                    ];
                } else {
                    $elements[$rowPos][$colPos] = $GridHelper->findElementsByGridUid($gridUid, 1, $rowPos, $colPos);
                }
            }
        }

        foreach($elements as $rowPos => $colArr) {
            foreach($colArr as $colPos => $elements) {
                $renderedColsHTML[$colPos] = $ElementComponent->renderElements($elements, "Centauri::Frontend.Elements");
            }
        }

        

        $renderedHTML = view("Centauri::Frontend.Grids." . $value, [
            "renderedColsHTML" => $renderedColsHTML,
            "grid" => $data["element"]
        ])->render();

        $renderedHTML = str_replace("  ", "", $renderedHTML);
        $renderedHTML = str_replace("\r\n", "", $renderedHTML);

        $data["element"]->elements = $elements;
        $data["element"]->renderedHtml = $renderedHTML;

        return $data;
    }
}
