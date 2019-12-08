<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\Model\Page;

class PageService
{
    public function createNewPage($attributes, $lid = 1)
    {
        $page = new Page($attributes);

        $page->lid = $lid;

        return $page;
    }
}
