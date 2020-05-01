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
        $renderedHTML = $ElementComponent->renderElements($elements);
        $renderedHTML = str_replace("  ", "", $renderedHTML);
        $renderedHTML = str_replace("\r\n", "", $renderedHTML);

        $data["element"]->elements = $elements;
        $data["element"]->renderedHtml = $renderedHTML;

        return $data;
    }
}
