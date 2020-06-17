<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Model\Page;
use Centauri\CMS\Utility\DomainsUtility;

class BuildBladeHelper
{
    protected static $domainsUtility;
    protected static $pageBladeUtility;
    protected static $linkBladeUtility;

    public static function initClasses($type)
    {
        if($type == "domains") {
            self::$domainsUtility = \Centauri\CMS\Utility\DomainsUtility::class;
        }

        if($type == "page") {
            self::$pageBladeUtility = \Centauri\CMS\Utility\BladeUtility\PageBladeUtility::class;
        }

        if($type == "link") {
            self::$linkBladeUtility = \Centauri\CMS\Utility\BladeUtility\LinkBladeUtility::class;
        }
    }

    public static function treeByPid($startId, $pageUid, $lid)
    {
        self::initClasses("domains");
        self::initClasses("page");

        $pages = Page::where([
            "pid" => $startId,
            "lid" => $lid,
            "hidden" => 0,
            "hidden_inpagetree" => 0
        ])->orderBy("pid", "ASC")->get()->all();

        if(empty($pages)) {
            $pages = Page::where([
                "pid" => $startId,
                "lid" => $lid,
                "hidden" => 0,
                "hidden_inpagetree" => 0
            ])->orderBy("pid", "ASC")->get()->all();
        }

        foreach($pages as $page) {
            $page->domainConfig = DomainsUtility::findDomainConfigByPageUid($pageUid);
            $npages[] = $page;
        }

        $pages = self::$pageBladeUtility::getSubpagesByPages($pages, $pageUid, "uid", null, $lid);
        return $pages;
    }

    public static function treeByStorageId($storage_id, $page = null, $lid = 1)
    {
        self::initClasses("page");

        $pages = Page::where("storage_id", $storage_id)->get()->all();
        $pages = self::$pageBladeUtility::getSubpagesByPages($pages, $storage_id, "storage_id", $page, $lid);

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
