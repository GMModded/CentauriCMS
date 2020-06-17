<?php
namespace Centauri\CMS\Helper;

use Centauri\CMS\Model\Page;

class PageHelper
{
    /**
     * @todo Finish logic and main purpose of this static function.
     */
    public static function getRootpageByPage($page)
    {
        /*
        if($page->pid != 0) {
            $parentPage = Page::where("uid", $page->pid)->get()->first();
            dd($parentPage);
            self::getRootpageByPage($page);
        }
        */
    }
}
