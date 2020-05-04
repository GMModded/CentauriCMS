<?php
namespace Centauri\CMS\Processor;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Helper\GridHelper;

class GridsProcessor
{
    public static function process($data)
    {
        $GridHelper = Centauri::makeInstance(GridHelper::class);

        $gridUid = $data["element"]->uid;
        $elements = $GridHelper->findElementsByGridUid($gridUid);

        $ElementComponent = Centauri::makeInstance(ElementComponent::class);

        $renderedHTML = "";
        $renderedColsHTML = [];

        $gridLayout = $data["value"];

        if($gridLayout == "onecol") {
            $renderedColsHTML = [
                $ElementComponent->renderElements($elements)
            ];
        } else if($gridLayout == "twocol") {
            $renderedColsHTML = [
                $ElementComponent->renderElements($elements, 1, 0, 0, 3),
                $ElementComponent->renderElements($elements, 1, 0, 0, 4)
            ];
        } else if($gridLayout == "threecol") {
            $renderedColsHTML = [
                $ElementComponent->renderElements($elements, 1, 0, 0, 3),
                $ElementComponent->renderElements($elements, 1, 0, 0, 4),
                $ElementComponent->renderElements($elements, 1, 0, 0, 5)
            ];
        } else if($gridLayout == "fourcol") {
            $renderedColsHTML = [
                $ElementComponent->renderElements($elements, 1, 0, 0, 3),
                $ElementComponent->renderElements($elements, 1, 0, 0, 4),
                $ElementComponent->renderElements($elements, 1, 0, 0, 5),
                $ElementComponent->renderElements($elements, 1, 0, 0, 6)
            ];
        } else {
            dd("GRIDS PROCESSOR");
        }

        $renderedHTML = view("Centauri::Frontend.Grids." . $gridLayout, [
            "renderedColsHTML" => $renderedColsHTML
        ])->render();

        $renderedHTML = str_replace("  ", "", $renderedHTML);
        $renderedHTML = str_replace("\r\n", "", $renderedHTML);

        $data["element"]->elements = $elements;
        $data["element"]->renderedHtml = $renderedHTML;

        return $data;
    }
}
