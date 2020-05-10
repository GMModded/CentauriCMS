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

    public static function getSubpagesByPages($pages, $currentPageUid = null, $field = "uid", $crtPage = null)
    {
        foreach($pages as $page) {
            if(!is_null($currentPageUid)) {
                if($field == "uid") {
                    if($page->$field == $currentPageUid && $page->storage_uid == null) {
                        $page->current = true;
                    }
                } else {
                    if($page->getAttribute($field) == $currentPageUid) {
                        if(!is_null($crtPage)) {
                            if($crtPage->storage_id == $page->storage_id) {
                                if($page->uid == $crtPage->uid) {
                                    $page->current = true;
                                }
                            }
                        }
                    }
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
