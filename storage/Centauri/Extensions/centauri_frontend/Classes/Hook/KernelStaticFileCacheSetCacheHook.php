<?php
namespace Centauri\Extension\Frontend\Hook;

use Centauri\CMS\Centauri;
use Illuminate\Support\Str;

class KernelStaticFileCacheSetCacheHook
{
    public function __construct($params)
    {
        $cachedFilename = $params["cachedFilename"];
        $html = $params["data"];

        $splittedHtml = explode("\n", $html);

        $startSections = [];
        $endSections = [];

        foreach($splittedHtml as $key => $line) {
            if(Str::startsWith($line, "<section id=")) {
                $startSections[] = [
                    "startKey" => $key,
                    "line" => $line
                ];
            }

            if($line == "</section>") {
                $endSections[] = [
                    "endKey" => $key
                ];
            }
        }

        $sectionsHTML = [];

        foreach($startSections as $startIndex => $startArr) {
            $startKey = $startArr["startKey"];
            $endKey = $endSections[$startIndex]["endKey"];

            $id = $startArr["line"];
            $id = str_replace("<section id=", "", $id);
            $id = str_replace('"', "", $id);
            $id = str_replace(">", "", $id);

            $sectionsHTML[$id] = Centauri::getArrayBetweenKeys($splittedHtml, $startKey + 1, $endKey - 1);
        }

        $cachedHTML = "";

        if(empty($_POST)) {
            $cachedHTML = $html;
        } else {
            $cachedFilename = $cachedFilename . "_content";
            $cachedHTML = $sectionsHTML["content"] ?? $html;
        }

        return [
            "cachedFilename" => $cachedFilename,
            "data" => $cachedHTML
        ];
    }
}
