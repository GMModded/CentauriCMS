<?php
namespace Centauri\Extension\Jobs\Handler;

use Centauri\CMS\Helper\GetModelBySlugHelper;
use Centauri\CMS\Http\FrontendRenderingHandler;
use Centauri\CMS\Model\Page;

class JobsRoutesHandler
{
    private $extensionKey = "centauri_jobs";

    public function __construct($params)
    {
        $GLOBALS["Centauri"]["Handlers"]["routes"][$this->extensionKey][] = [
            function() use ($params) {
                \Illuminate\Support\Facades\Route::any("/jobs/{name}", function($name = "") use ($params) {
                    GetModelBySlugHelper::setModelnamespace($params["modelNamespace"]);
                    $jobItem = GetModelBySlugHelper::findBySlug($name);

                    $jobHtml = view("centauri_jobs::Frontend/show", [
                        "jobItem" => $jobItem
                    ])->render();

                    $page = Page::where("slugs", "/jobs")->get()->first();
                    return FrontendRenderingHandler::renderFrontendWithContent($page, $jobHtml);
                });
            }
        ];
    }
}
