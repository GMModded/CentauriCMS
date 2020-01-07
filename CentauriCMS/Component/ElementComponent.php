<?php
namespace Centauri\CMS\Component;

use Centauri\CMS\Centauri;

class ElementComponent
{
    /**
     * Function to render content elements either by frontend or backend and optional given lid (LanguageID)
     * 
     * @param string $view Can be either "frontend", "FE", "backend" or "BE"
     * @param string|int $pageUid Uid of the page to render
     * @param string|int $lid Elements from specific language
     * @return void
     */
    public function render($view, $pageUid, $lid = 0)
    {
        if($view == "frontend" || $view == "FE") {
            $elements = \Centauri\CMS\Model\Element::where([
                "pid" => $pageUid,
                "lid" => $lid,
                "hidden" => 0
            ])->orderBy("sorting", "asc")->get();

            $renderedHTML = "";

            foreach($elements as $element) {
                $data = [];

                if($element->ctype == "plugin") {
                    $className = $element->plugin;
                    $data = Centauri::makeInstance($className, $element);
                }

                $element = \Centauri\CMS\Processor\FieldProcessor::process($element, $data);

                $renderedHTML .= view("Centauri::Frontend.Elements." . $element->getAttribute("ctype"), [
                    "element" => $element,
                    "data" => $data
                ])->render();
            }

            return $renderedHTML;
        }

        return;
    }
}
