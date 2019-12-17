<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Illuminate\Support\Facades\Storage;

class ModulesService
{
    /**
     * Init method of this class
     * 
     * @return void
     */
    public function init()
    {
        $modules = [
            "dashboard" => [
                "title" => trans("backend/modules.dashboard.title")
            ],

            "pages" => [
                "title" => trans("backend/modules.pages.title")
            ],

            "languages" => [
                "title" => trans("backend/modules.languages.title")
            ],

            "extensions" => [
                "title" => trans("backend/modules.extensions.title")
            ]
        ];

        $hooks = (!empty($GLOBALS["Centauri"]["Hook"]["ModulesHook"])) ?? $GLOBALS["Centauri"]["Hook"]["ModulesHook"];
        if($hooks) {
            foreach($hooks as $hook) {
                $hookClass = Centauri::makeInstance($hook);
                dd($hookClass);
            }
        } else {
            foreach($modules as $moduleid => $data) {
                // Default icon for BE-Modules
                $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="#758CA3" fill-rule="evenodd" d="M10,9 C9.44771525,9 9,9.44771525 9,10 L9,21 C9,21.5522847 9.44771525,22 10,22 L21,22 C21.5522847,22 22,21.5522847 22,21 L22,10 C22,9.44771525 21.5522847,9 21,9 L10,9 Z M15,7 L15,3 C15,2.44771525 14.5522847,2 14,2 L3,2 C2.44771525,2 2,2.44771525 2,3 L2,14 C2,14.5522847 2.44771525,15 3,15 L7,15 L7,10 C7,8.34314575 8.34314575,7 10,7 L15,7 Z M17,7 L21,7 C22.6568542,7 24,8.34314575 24,10 L24,21 C24,22.6568542 22.6568542,24 21,24 L10,24 C8.34314575,24 7,22.6568542 7,21 L7,17 L3,17 C1.34314575,17 1.09108455e-15,15.6568542 8.8817842e-16,14 L0,3 C-2.02906125e-16,1.34314575 1.34314575,7.80279975e-16 3,8.8817842e-16 L14,8.8817842e-16 C15.6568542,6.15657427e-16 17,1.34314575 17,3 L17,7 Z"></path></svg>';

                if(Storage::exists("icon-" . $moduleid)) {
                    $icon = Storage::get("icon_" . $moduleid);
                }

                $modules[$moduleid]["icon"] = $icon;
            }
        }

        $GLOBALS["Centauri"]["Core"]["Modules"] = $modules;
    }

    /**
     * Returns all modules - optionally for views optimized - for blades eaching it etc
     * 
     * @param boolean $viewsOptimized
     * @return void
     */
    // public function findAll($viewsOptimized = false)
    // {
        
    // }

    /**
     * Handles different dynamic data for every single module in the backend
     * 
     * @param string $moduleid - The ID of the module (attribute: data-moduleid) e.g. "dashboard" or "pages" etc.
     * @return array
     */
    public function findDataByModuleid($moduleid)
    {
        $data = [];

        if($moduleid == "dashboard") {
            $rootpages = Page::where("is_rootpage", "1")->get()->count();
            $pages = Page::where("is_rootpage", "0")->get()->count();
            $languages = Language::all()->count();

            $data = [
                "rootpages" => $rootpages,
                "pages" => $pages,
                "languages" => $languages
            ];
        }

        if($moduleid == "pages") {
            $languages = Language::all();

            $pages = Page::all();
            $npages = [];

            foreach($pages as $page) {
                if($page->getAttribute("is_rootpage")) {
                    $language = Language::where("uid", $page->lid)->get()->toArray()[0];

                    $flagsrc = env("APP_URL") . "/" . $language["flagsrc"];
                    $language["flagsrc"] = $flagsrc;

                    $page->setAttribute("language", $language);
                    $npages[$page->getAttribute("lid")][$page->getAttribute("uid")][] = $page;
                }
            }
            foreach($pages as $page) {
                if(!$page->getAttribute("is_rootpage")) {
                    $language = Language::where("uid", $page->lid)->get()->toArray()[0];

                    $flagsrc = env("APP_URL") . "/" . $language["flagsrc"];
                    $language["flagsrc"] = $flagsrc;

                    $page->setAttribute("language", ["flagsrc" => $flagsrc]);
                    $npages[$page->getAttribute("lid")][$page->getAttribute("pid")][] = $page;
                }
            }

            $data = [
                "pages" => $npages,
                "languages" => $languages
            ];
        }

        if($moduleid == "languages") {
            $languages = Language::all();

            $data = [
                "languages" => $languages
            ];
        }


        if(isset($data["languages"]) && gettype($data["languages"]) != "integer") {
            foreach($languages as $language) {
                $flagsrc = env("APP_URL") . "/" . $language->getAttribute("flagsrc");
                $language->setAttribute("flagsrc", $flagsrc);
            }
        }

        return $data;
    }
}
