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

    public static function getSubpagesByPages($pages)
    {
        foreach($pages as $page) {
            $_pages = self::findPAgesByPid($page->uid);

            if(!empty($_pages)) {
                $page->pages = self::getSubpagesByPages($_pages);
            }

            $page->pages = $_pages;
        }

        return $pages;
    }
}
