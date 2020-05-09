<?php
namespace Centauri\Extension;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Frontend\Elements\Elements;

class Frontend
{
    public function __construct()
    {
        // Register of all Frontend Elements
        Centauri::makeInstance(Elements::class);

        // Register of Configuration-Array for $GLOBALS["Centauri"]["Extensions"]["centauri_frontend"]
        $GLOBALS["Centauri"]["Extensions"]["centauri_frontend"] = [
            "config" => [
                "Elements" => [
                    "ViewNamespace" => [
                        // "headerdescription" => "centauri_frontend::Frontend.Templates.Elements",
                        // "headerimage" => "centauri_frontend::Frontend.Templates.Elements",
                        "slider" => "centauri_frontend::Frontend.Templates.Elements"
                    ]
                ]
            ]
        ];

        // Views registration through ViewResolver class
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("centauri_frontend", "EXT:centauri_frontend/Views");
    }

    public static function rendering($page)
    {
        $uid = $page->uid;
        $lid = $page->lid;

        $ElementComponent = Centauri::makeInstance(ElementComponent::class);

        $contentColHTML = $ElementComponent->render($uid, $lid, 0, 0);
        // $leftColHTML = $ElementComponent->render($uid, $lid, 1, 2);
        // $rightColHTML = $ElementComponent->render($uid, $lid, 1, 3);

        $params = request()->post();
        $dynPageRequest = $params["dynPageRequest"] ?? null;

        return view("centauri_frontend::Frontend/Layouts/frontend", [
            "contentColHTML" => $contentColHTML,
            // "leftColHTML" => $leftColHTML,
            // "rightColHTML" => $rightColHTML,
            "dynPageRequest" => $dynPageRequest
        ])->render();
    }
}
