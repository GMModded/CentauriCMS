<?php
namespace Centauri\CMS\Component;

use Centauri\CMS\Centauri;

class ElementComponent
{
    /**
     * Function to render content elements either by frontend or backend and optional given lid (LanguageID)
     * 
     * @param string|int $pageUid Uid of the page to render
     * @param string|int $lid Elements from specific language
     * @param int $rowPos The rowPos configurable by beLayout
     * @param int $colpos The colPos configurable by beLayout
     * 
     * @return void
     */
    public function render($pageUid, $lid = 1, $rowPos = 0, $colPos = 0, $grids_sorting = [])
    {
        $_grids_sorting = [
            "grids_sorting_rowpos" => null,
            "grids_sorting_colpos" => null
        ];

        if(!empty($grids_sorting)) {
            foreach($grids_sorting as $key => $value) {
                $_grids_sorting[$key] = $value;
            }
        }

        $elements = \Centauri\CMS\Model\Element::where([
            "pid" => $pageUid,
            "lid" => $lid,
            "hidden" => 0,
            "rowPos" => $rowPos,
            "colPos" => $colPos,
            "grids_sorting_rowpos" => $_grids_sorting["grids_sorting_rowpos"],
            "grids_sorting_colpos" => $_grids_sorting["grids_sorting_colpos"]
        ])->orderBy("sorting", "asc")->get();

        return $this->getRenderedHtmlByElements($elements);
    }

    public function renderElements($elements)
    {
        return $this->getRenderedHtmlByElements($elements);
    }

    public function getRenderedHtmlByElements($elements)
    {
        $renderedHTML = "";

        foreach($elements as $element) {
            $data = [];

            if($element->ctype == "plugin") {
                $className = $element->plugin;
                $data = Centauri::makeInstance($className, $element);
            }

            $element = \Centauri\CMS\Processor\FieldProcessor::process($element, $data);

            $renderedHTML .= view("Centauri::Frontend.Elements." . $element->ctype, [
                "element" => $element,
                "data" => $data
            ])->render();
        }

        return $renderedHTML;
    }
}
