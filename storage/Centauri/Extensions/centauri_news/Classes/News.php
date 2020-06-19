<?php
namespace Centauri\Extension\News;

use Centauri\CMS\Centauri;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\News\Handler\NewsRoutesHandler;
use Centauri\Extension\News\CME\NewsCME;
use Centauri\Extension\News\Models\NewsModel;

class News
{
    private $modelNamespace = "\Centauri\Extension\News\Models\NewsModel";

    public function __construct()
    {
        // Backend News Module
        // Centauri::makeInstance(NewsModule::class);

        // Backend Example/Test Content Element (customheaderfield and customtab)
        // Centauri::makeInstance(TestElement::class);

        /**
         * News Plugin
         */
        $GLOBALS["Centauri"]["Plugins"]["centauri_news_pi1"] = [
            "News Plugin" => "\Centauri\Extension\Plugins\NewsPlugin"
        ];

        /**
         * News Model
         */
        Centauri::makeInstance(NewsCME::class, [
            "modelNamespace" => $this->modelNamespace
        ]);

        /**
         * Views registration via ViewResolver class
         */
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("centauri_news", "EXT:centauri_news/Views");

        /**
         * NewsRoutesHandler
         */
        Centauri::makeInstance(NewsRoutesHandler::class, [
            "modelNamespace" => $this->modelNamespace
        ]);
    }

    public function showAction($parameters)
    {
        $uid = $parameters["uid"];
        $newsItem = NewsModel::where("uid", $uid)->get()->first();

        return view("centauri_news::Frontend/show", [
            "newsItem" => $newsItem
        ])->render();
    }
}
