<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Model\Page;

class MenuBladeHelper
{
    public static function buildTreeByParentId($pid)
    {
        $tree = [];
        $page = null;

        if($pid == 1) {
            $page = Page::where("pid", $pid)->get()->first();
            $tree[] = $page;
        } else {
            $pages = Page::where("pid", $pid)->get()->all();
            return $pages;
        }

        foreach($tree as $item) {
            $tree[] = self::buildTreeByParentId($item->pid);
        }

        return $tree;
    }
}
