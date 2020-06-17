<?php
namespace Centauri\Extension\Modules;

class NewsModule
{
    public function __construct()
    {
        $GLOBALS["Centauri"]["Modules"]["centauri_news_mod1"] = [
            "title" => "News",
            "icon" => "<i class='fas fa-list'></i>",
            "DataFetcher" => \Centauri\Extension\Fetcher\NewsModuleFetcher::class
        ];
    }
}
