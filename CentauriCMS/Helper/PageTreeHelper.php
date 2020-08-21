<?php
namespace Centauri\CMS\Helper;

class PageTreeHelper
{
    /**
     * Generates the HTML-code for tree-views
     * 
     * @param array $tree - The array of a tree (can hold infinite childs)
     * @param array $config - Configuration for this static method - available keys are "childKey" and "titleKey"
     *                        which are used to make the infinite loop for childs and display it correctly in the gen. HTML
     * 
     * Example:
     * - $tree = pages-array,
     * - $childKey = "subgpages" (key inside an array of $tree),
     * - $titleKey = "pageTitle"
     * 
     * @return string|void
     */
    public static function buildTreeHTML($tree)
    {
        $childKey = "pages";
        $titleKey = "title";

        $html = "";
        $i = 0;

        foreach($tree as $parent) {
            // $domainConfig = DomainsUtility::findDomainConfigByPageUid($parent->uid);
            // $host = DomainsUtility::getUriByConfig($domainConfig);

            $html .= "<div class='root'><div data-type='root' data-uid='" . $parent->uid . "' data-pid='" . $parent->pid . "' tabindex='" . $i . "'>" . $parent->$titleKey . "</div>";

            if(!empty($parent->$childKey)) {
                $html .= "<div class='items'>";
                    $html .= self::buildSubPageTreeHTML($parent->$childKey);
                $html .= "</div>";
            }

            $html .= "</div>";
            $i++;
            $data = "";
        }

        return $html;
    }

    public static function buildSubPageTreeHTML($tree)
    {
        $childKey = "pages";
        $titleKey = "title";

        $html = "";
        $i = 0;

        foreach($tree as $parent) {
            $html .= "<div data-type='item' data-uid='" . $parent->uid . "' data-pid='" . $parent->pid . "' tabindex='" . $i . "' style='padding-left: 10px;'>" . $parent->$titleKey . "</div>";

            if(!empty($parent->$childKey)) {
                $html .= "<div class='subitems' style='padding-left: 10px;'>" . self::buildSubPageTreeHTML($parent->$childKey) . "</div>";
            }
        }

        return $html;
    }
}
