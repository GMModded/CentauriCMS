<?php
namespace Centauri\Extension\Frontend;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Frontend\Elements\Elements;

class Frontend
{
    private $extensionKey = "centauri_frontend";

    /**
     * Constructor of this class
     * 
     * @return void
     */
    public function __construct()
    {
        /**
         * Register of all Frontend Elements
         */
        Centauri::makeInstance(Elements::class);

        /**
         * Register of Configuration-Array for $GLOBALS["Centauri"]["Extensions"][$this->extensionKey]
         */
        $GLOBALS["Centauri"]["Extensions"][$this->extensionKey] = $this->getConfig();

        /**
         * Register of custom pageNotFound Handler
         */
        $GLOBALS["Centauri"]["Handlers"]["pageNotFound"] = \Centauri\Extension\Frontend\Http\PageNotFound::class;

        /**
         * Views registration through ViewResolver class
         */
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register($this->extensionKey, "EXT:" . $this->extensionKey . "/Views");
    }

    /**
     * Returns the configuration for this array for the $GLOBALS-array
     * 
     * @return array
     */
    public function getConfig()
    {
        // $pusherConfig = config("broadcasting")["connections"]["pusher"];

        return [
            "config" => [
                "Elements" => [
                    "ViewNamespace" => [
                        "headerdescription" => "centauri_frontend::Frontend.Templates.Elements",
                        "headerimage" => "centauri_frontend::Frontend.Templates.Elements",
                        "slider" => "centauri_frontend::Frontend.Templates.Elements",
                        "boxitems" => "centauri_frontend::Frontend.Templates.Elements",
                        "titleteaser" => "centauri_frontend::Frontend.Templates.Elements"
                    ]
                ]
            ]
        ];
    }

    /**
     * Static function defined in /config/centauri.php -> ["beLayouts"]["default"]["rendering"]
     * 
     * @param \Centauri\CMS\Model\Page $page
     * @return void
     */
    public static function rendering($page)
    {
        $uid = $page->uid;
        $lid = $page->lid;

        $ElementComponent = Centauri::makeInstance(ElementComponent::class);

        $domain = $page->getDomain();
        $id = "Main";

        if(!is_null($domain)) {
            $id = $domain->id;
        }

        $contentColHTML = $ElementComponent->render($uid, $lid, 0, 0);

        $template = "frontend";

        if($id == "Docs") {
            $template = "docs";
        }

        return view("centauri_frontend::Frontend.Layouts." . $template, [
            "domain" => $domain,
            "contentColHTML" => $contentColHTML
        ])->render();
    }
}
