<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Model\Page;

class BuildBladeHelper
{
    protected static $pageBladeUtility;
    protected static $linkBladeUtility;

    public static function initClasses($type)
    {
        if($type == "page") {
            self::$pageBladeUtility = \Centauri\CMS\Utility\BladeUtility\PageBladeUtility::class;
        }

        if($type == "link") {
            self::$linkBladeUtility = \Centauri\CMS\Utility\BladeUtility\LinkBladeUtility::class;
        }
    }

    public static function treeByPid($pid, $pageUid = null)
    {
        self::initClasses("page");

        $pages = Page::where([
            "pid" => $pid,
            "hidden" => 0,
            "hidden_inpagetree" => 0
        ])->get()->all();

        $pages = self::$pageBladeUtility::getSubpagesByPages($pages, $pageUid);

        return $pages;
    }

    public static function linkByUid($uid)
    {
        self::initClasses("link");

        $page = Page::where("uid", $uid)->get()->first();

        if(is_null($page)) {
            return;
        }

        return self::$linkBladeUtility::getLinkByPage($page);
    }
}
