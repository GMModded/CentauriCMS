<?php
namespace Centauri\CMS\Http;

use Centauri\CMS\Centauri;
use Centauri\CMS\Resolver\ViewResolver;

class FrontendRenderingHandler
{
    public static function getAdditonalHeadTagContent() {
        $additionalHeadTagContent = "";

        foreach($GLOBALS["Centauri"]["AdditionalDataFuncs"]["Frontend"]["Tags"]["Head"] as $headClass) {
            $instance = Centauri::makeInstance($headClass);
            $additionalHeadTagContent .= $instance->fetch();
        }

        return $additionalHeadTagContent;
    }

    public static function getPreparedFrontendHtml($page, $renderedHTML, $additionalHeadTagContent)
    {
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("Centauri", "CentauriCMS/Views");

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
