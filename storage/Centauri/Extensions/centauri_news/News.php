<?php
namespace Centauri\Extension;

use Centauri\CMS\Centauri;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Modules\NewsModule;
use Centauri\Extension\Elements\TestElement;

class News
{
    public function __construct()
    {
        // Backend News Module
        Centauri::makeInstance(NewsModule::class);

        // Backend Example/Test Content Element (customheaderfield and customtab)
        // Centauri::makeInstance(TestElement::class);

        // Backend News Plugin
        $GLOBALS["Centauri"]["Plugins"]["centauri_news_pi1"] = [
            "News Plugin" => "\Centauri\Extension\Plugin\NewsPlugin"
        ];

        // Backend News Model
        $GLOBALS["Centauri"]["Models"]["\Centauri\Extension\Model\News"] = [
            "namespace" => "centauri_news",
            "tab" => "general",
            "label" => "Centauri » News",
            "listLabel" => "{title} by <b>{author}</b>",

            "fields" => [
                "title" => [
                    "label" => trans("centauri_news::backend/global.label.title"),
                    "type" => "input"
                ],
                "headerimage" => [
                    "label" => "HEADERIMAGE BRO",
                    "type" => "image"
                ]
            ]
        ];

        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("centauri_news", "EXT:centauri_news/Views");
    }
}
