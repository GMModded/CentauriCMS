<?php
namespace Centauri\Extension\News\Handler;

use Centauri\CMS\Helper\GetModelBySlugHelper;
use Centauri\CMS\Http\FrontendRenderingHandler;
use Centauri\CMS\Model\Page;

class NewsRoutesHandler
{
    private $extensionKey = "centauri_news";
    private $slug = "news";

    public function __construct($params)
    {
        $GLOBALS["Centauri"]["Handlers"]["routes"][$this->extensionKey][] = [
            function() use ($params) {
                \Illuminate\Support\Facades\Route::any("/" . $this->slug . "/{title}", function($title = "") use ($params) {
                    GetModelBySlugHelper::setModelnamespace($params["modelNamespace"]);
                    $newsItem = GetModelBySlugHelper::findBySlug($title);

                    $newsHtml = view($this->extensionKey . "::Frontend/show", [
                        "newsItem" => $newsItem
                    ])->render();

                    $page = Page::where("slugs", "/" . $this->slug)->get()->first();
                    return FrontendRenderingHandler::renderFrontendWithContent($page, $newsHtml);
                });
            }
        ];
    }
}
