<?php
namespace Centauri\CMS\Utility;

use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Page;

class FixerUtility
{
    public function fix($name)
    {
        if($name == "deletePagesWithNotExistingLanguage") {
            $pages = Page::all();
            $log = [];

            foreach($pages as $page) {
                $lid = $page->lid;

                $language = Language::where("uid", $lid)->get()->first();
                if(is_null($language)) {
                    Page::destroy($page->uid);
                    $log[] = "Destroyed non-existing page with uid: '" . $page->uid . "'";
                }
            }

            echo json_encode($log);
            return redirect("./centauri/pages");
        }

        return redirect("./centauri");
    }
}
