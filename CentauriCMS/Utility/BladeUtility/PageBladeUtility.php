<?php
namespace Centauri\CMS\Utility\BladeUtility;

use Centauri\CMS\Model\Page;

class PageBladeUtility
{
    public static function findPageByUid($uid)
    {
        return Page::where("uid", $uid)->get()->first();
    }

    public static function findPagesByPid($pid)
    {
        return Page::where("pid", $pid)->get()->all();
    }

    public static function getSubpagesByPages($pages, $currentPageUid = null)
    {
        foreach($pages as $page) {
            if(!is_null($currentPageUid)) {
                if($page->uid == $currentPageUid) {
                    $page->current = true;
                }
            }

            $_pages = self::findPagesByPid($page->uid);

            if(!empty($_pages)) {
                $page->pages = self::getSubpagesByPages($_pages);
            }

            $page->pages = $_pages;
        }

        return $pages;
    }
}
