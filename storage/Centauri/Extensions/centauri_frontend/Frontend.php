<?php
namespace Centauri\Extension;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Elements\TestElement;

class Frontend
{
    public function __construct()
    {
        // Backend Example/Test Content Element (customheaderfield and customtab)
        // Centauri::makeInstance(TestElement::class);

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
        $leftColHTML = $ElementComponent->render($uid, $lid, 1, 2);
        $rightColHTML = $ElementComponent->render($uid, $lid, 1, 3);

        return view("centauri_frontend::Frontend/frontend", [
            "contentColHTML" => $contentColHTML,
            "leftColHTML" => $leftColHTML,
            "rightColHTML" => $rightColHTML
        ])->render();
    }
}
