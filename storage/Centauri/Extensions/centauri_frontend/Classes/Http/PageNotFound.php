<?php
namespace Centauri\Extension\Frontend\Http;

use Centauri\CMS\Centauri;
use Centauri\CMS\Exception\CentauriException;
use Centauri\CMS\Http\FrontendRenderingHandler;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Utility\DomainsUtility;
use Exception;

class PageNotFound
{
    public static function handle()
    {
        $crtServerHTTPHost = $_SERVER["HTTP_HOST"];

        $domainFile = DomainsUtility::getDomainFileByHost($crtServerHTTPHost);
        $domainCfg = $domainFile->content;

        $pageNotFoundUid = $domainCfg->pageNotFound;
        $page = Page::where("uid", $pageNotFoundUid)->get()->first();

        if(is_null($page)) {
            if(Centauri::keepSiteAlive()) {
                return redirect("/");
            }

            throw new Exception("The 404-page with the UID '" . $pageNotFoundUid . "' doesn't exists!");
        }

        if($domainCfg->domain != $crtServerHTTPHost) {
            throw new CentauriException("Page not found. 404-Error handling not properly configured - this 404-page is not for this rootpage!");
        }

        $additionalHeadTagContent = FrontendRenderingHandler::getAdditonalHeadTagContent();

        $beLayoutCfg = $page->getBackendLayoutConfig();
        $renderedHTML = Centauri::makeInstance($beLayoutCfg["rendering"])::rendering($page);
        $frontendHtml = FrontendRenderingHandler::getPreparedFrontendHtml($page, $renderedHTML, $additionalHeadTagContent);

        $frontendHtml = view("centauri_frontend::Frontend.Templates.pageNotFound", [
            "renderedHTML" => $frontendHtml
        ])->render();

        return response($frontendHtml, 404);
    }
}
