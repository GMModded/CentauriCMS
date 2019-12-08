<?php
namespace Centauri\CMS\Service;

use App\Page;

class PageService
{
    public function createNewPage($attributes, $lid = 1)
    {
        $page = new Page($attributes);

        $page->lid = $lid;

        return $page;
    }
}
