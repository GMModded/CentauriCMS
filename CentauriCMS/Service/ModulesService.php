<?php
namespace Centauri\CMS\Service;

use App\Language;
use App\Page;

class ModulesService
{
    /**
     * Handles different dynamic data for every single module in the backend
     * 
     * @param string $moduleid - The ID of the module (attribute: data-moduleid) e.g. "dashboard" or "pages" etc.
     * 
     * @return array
     */
    public function findDataByModuleid($moduleid)
    {
        $data = [];

        if($moduleid == "pages") {
            $languages = Language::all();

            $pages = Page::all();
            $npages = [];

            foreach($pages as $page) {
                if($page->getAttribute("is_rootpage")) {
                    $page->language = Language::where("uid", $page->lid)->get()->toArray()[0];
                    $npages[$page->getAttribute("lid")][$page->getAttribute("uid")][] = $page;
                }
            }
            foreach($pages as $page) {
                if(!$page->getAttribute("is_rootpage")) {
                    $page->language = Language::where("uid", $page->lid)->get()->toArray()[0];
                    $npages[$page->getAttribute("lid")][$page->getAttribute("pid")][] = $page;
                }
            }

            $data = [
                "pages" => $npages,
                "languages" => $languages
            ];
        }

        return $data;
    }
}
