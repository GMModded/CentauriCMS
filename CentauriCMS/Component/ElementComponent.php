<?php
namespace Centauri\CMS\Component;

use App;
use Illuminate\Contracts\Support\Arrayable;

class ElementComponent
{
    /**
     * Function to render content elements either by frontend or backend and optional given lid (LanguageID)
     * 
     * @param string $view Can be either "frontend", "FE", "backend" or "BE"
     * @param string|int $pageUid Uid of the page to render
     * @param string|int $lid Elements from specific language
     * 
     * @return void
     */
    public static function render($view, $pageUid, $lid = 0)
    {
        if($view == "frontend" || $view == "FE") {
            $elements = App\Element::where([
                "pid" => $pageUid,
                "lid" => $lid
            ])->get();

            $renderedHTML = "";

            foreach($elements as $element) {
                $element->data = json_decode($element->getAttribute("data"));

                $renderedHTML .= view("Frontend.Elements." . $element->getAttribute("ctype"), [
                    "data" => $element->getAttribute("data")
                ]);
            }

            return $renderedHTML;
        }

        if($view == "backend" || $view == "BE") {
            dd("BACKEND RENDER");
        }

        return;
    }
}
