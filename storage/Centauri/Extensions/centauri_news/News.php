<?php
namespace Centauri\Extension;

use Centauri\CMS\Centauri;
use Centauri\CMS\Http\FrontendRenderingHandler;
use Centauri\CMS\Http\Request;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Modules\NewsModule;
use Centauri\Extension\Elements\TestElement;
use Centauri\Extension\Model\News as ModelNews;

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
                "slug" => [
                    "type" => "input",
                    "label" => trans("centauri_news::backend/global.label.slug"),

                    "config" => [
                        "required" => 1
                    ]
                ],

                "title" => [
                    "type" => "input",
                    "label" => trans("centauri_news::backend/global.label.title")
                ],

                "headerimage" => [
                    "type" => "image",
                    "label" => "Headerimage"
                ],

                "description" => [
                    "type" => "rte",
                    "label" => "Description"
                ]
            ]
        ];

        // Views registration through ViewResolver class
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("centauri_news", "EXT:centauri_news/Views");

        // NewsRoutesHook-Registration for Show-Action
        $GLOBALS["Centauri"]["Hooks"]["RoutesHooks"]["NewsRoutesHook"] = \Centauri\Extension\Hook\NewsRoutesHook::class;

        $GLOBALS["Centauri"]["Handlers"]["routes"]["centauri_news"][] = [
            function() {
                \Illuminate\Support\Facades\Route::any("/news/{title}", function($title = "") {
                    $page = Page::where("slugs", "/news")->get()->first();
                    $newsItem = ModelNews::where("slug", $title)->get()->first();

                    $newsHtml = view("centauri_news::Frontend/show", [
                        "newsItem" => $newsItem
                    ])->render();

                    return FrontendRenderingHandler::renderFrontendWithContent($page, $newsHtml);
                });
            }
        ];
    }

    public function showAction($parameters)
    {
        $uid = $parameters["uid"];
        $newsItem = ModelNews::where("uid", $uid)->get()->first();

        return view("centauri_news::Frontend/show", [
            "newsItem" => $newsItem
        ])->render();
    }
}
