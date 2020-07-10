<?php
namespace Centauri\Extension\Frontend\Http;

use Centauri\CMS\Centauri;
use Centauri\CMS\Http\FrontendRenderingHandler;
use Centauri\CMS\Model\Notification;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Utility\DomainsUtility;

class PageNotFound
{
    public static function handle()
    {
        $crtServerHTTPHost = $_SERVER["HTTP_HOST"];

        $domainFile = DomainsUtility::getDomainFileByHost($crtServerHTTPHost);
        $domainCfg = $domainFile->content;

        $pageNotFoundUid = $domainCfg->pageNotFound ?? null;
        $page = Page::where("uid", $pageNotFoundUid)->get()->first();

        if($domainCfg->domain != $crtServerHTTPHost) {
            if(is_null($page)) {
                if(Centauri::keepSiteAlive()) {
                    return redirect("/");
                }
    
                if(Centauri::keepSiteAlive()) {
                    $notification = new Notification;
                    $notification->severity = 1;
                    $notification->title = "404-Page for Domain-ID '" . $domainCfg->id . "'";
                    $notification->description = "The configured Page-ID doesn't exists!";
                    $notification->save();
                } else {
                    throw new \Exception("The 404-page with the UID '" . $pageNotFoundUid . "' doesn't exists!");
                }
            }

            throw new \Exception("Page not found. 404-Error handling not properly configured - this 404-page is not for this rootpage!");
        }

        if(is_null($page) && Centauri::keepSiteAlive()) {
            return redirect("/", 302, [
                "Centauri-Redirect" => "404-page-not-found"
            ]);
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
