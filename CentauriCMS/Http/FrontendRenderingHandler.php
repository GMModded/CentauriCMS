<?php
namespace Centauri\CMS\Http;

use Centauri\CMS\Centauri;
use Centauri\CMS\Resolver\ViewResolver;

class FrontendRenderingHandler
{
    public static function getAdditonalHeadTagContent()
    {
        $additionalHeadTagContent = "";

        foreach($GLOBALS["Centauri"]["AdditionalDataFuncs"]["Frontend"]["Tags"]["Head"] as $headClass) {
            $instance = Centauri::makeInstance($headClass);
            $additionalHeadTagContent .= $instance->fetch();
        }

        return $additionalHeadTagContent;
    }

    public static function getSEOHeadTags($page, $additionalHeadTagContent)
    {
        $seoHeadTags = "";

        if($page->seo_keywords != "") {
            $seoHeadTags .= "<meta name='keywords' content='" . $page->seo_keywords . "' />";
        }
        if($page->seo_description != "") {
            $seoHeadTags .= "<meta name='description' content='" . $page->seo_description . "' />";
        }

        $additionalHeadTagContent .= $seoHeadTags;
        return $additionalHeadTagContent;
    }

    public static function getPreparedFrontendHtml($page, $renderedHTML, $additionalHeadTagContent)
    {
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("Centauri", "CentauriCMS/Views");

        $additionalHeadTagContent = self::getSEOHeadTags($page, $additionalHeadTagContent);

        $frontendHtml = view("Centauri::Frontend", [
            "page" => $page,
            "content" => $renderedHTML,
            "additionalHeadTagContent" => $additionalHeadTagContent
        ])->render();

        $frontendHtml = str_replace("  ", "", $frontendHtml);
        $frontendHtml = str_replace("\r\n", "", $frontendHtml);

        return $frontendHtml;
    }

    public static function renderFrontendWithContent($page, $content)
    {
        $additionalHeadTagContent = self::getAdditonalHeadTagContent();
        $frontendHtml = self::getPreparedFrontendHtml($page, $content, $additionalHeadTagContent);

        return $frontendHtml;
    }
}
