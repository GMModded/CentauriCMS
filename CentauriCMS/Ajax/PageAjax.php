<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\Centauri;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Service\PageService;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;

class PageAjax implements AjaxInterface
{
    private $pageService;

    public function __construct()
    {
        $this->pageService = Centauri::makeInstance(PageService::class);
    }

    public function request(Request $request, String $ajaxName)
    {
        $params = $request->input();

        if($ajaxName == "newPage") {
            $parentuid = null;
            if($request->has("parentuid")) {
                $parentuid = filter_var($params["parentuid"], FILTER_VALIDATE_INT);
            } else {
                return response("Parent-Page not found.\nPlease refresh/abort the current action!", 500);
            }

            $isrootpage = false;
            if($request->has("isrootpage")) {
                $isrootpage = filter_var($params["isrootpage"], FILTER_VALIDATE_BOOLEAN);
            }

            if(!$request->has("title") || $params["title"] == "") {
                return response("Title can't be empty.\nPlease type in a title for your page name!", 500);
            }

            $page = new Page;
            $page->pid = $parentuid;
            $page->title = $params["title"];
            $page->is_rootpage = $isrootpage;
            $page->backend_layout = 1;

            $url = $params["url"];

            if($isrootpage) {
                if(!$request->has("language")) {
                    return response("Selected language is not available as a rootpage!", 500);
                }

                $page->lid = $params["language"];
                $page->slugs = $url;
            } else {
                $parentPage = Page::where("uid", $parentuid)->get()->first();

                $page->lid = $parentPage->lid;
                $page->slugs = $params["url"] ?? "/";
            }

            return $this->savePage($page);
        }

        if($ajaxName == "editPage") {
            $uid = $params["uid"];

            $title = $params["title"];
            $url = $params["url"];

            $page = Page::where("uid", $uid)->get()->first();

            $page->title = $title;
            $page->slugs = $url;

            if($page->save()) {
                return json_encode([
                    "type" => "success",
                    "title" => "Page '" . $title . "' saved",
                    "description" => "Successfully updated '" . $title . "'"
                ]);
            }

            return json_encode([
                "type" => "error",
                "title" => "Updating Page failed",
                "description" => "An error occured while updating '" . $title . "'"
            ]);
        }

        if($ajaxName == "showPage") {
            $uid = $params["uid"];
            $page = Page::where("uid", $uid)->get()->first();

            $url = $page->slugs;
            return $url;
        }

        if($ajaxName == "deletePage") {
            $uid = $params["uid"];

            $page = Page::where("uid", $uid)->get()->first();
            $title = $page->title;

            Page::destroy($uid);

            return json_encode([
                "type" => "warning",
                "title" => "Page '$title' deleted",
                "description" => "This page has been deleted"
            ]);
        }

        if($ajaxName == "createTranslatedPage") {
            $uid = $params["uid"];
            $lid = $params["lid"];
            $title = $params["title"];
            $url = $params["url"];

            $page = Page::where("uid", $uid)->get()->first();

            $newPage = $page->replicate();
            $newPage->title = $title;
            $newPage->slugs = $url;
            $newPage->lid = $lid;
            $newPage->push();

            $language = Language::get("uid", $lid)->get()->first();

            return json_encode([
                "type" => "success",
                "title" => "Page '$title' translated to " . $language->lang_code,
                "description" => "This page has successfully been translated"
            ]);
        }

        if($ajaxName == "getRootPages") {
            $pages = Page::where("is_rootpage", 1)->get();

            $data = [];

            foreach($pages as $page) {
                $data[] = [
                    "name" => $page->title,
                    "value" => $page->uid
                ];
            }

            return json_encode($data);
        }

        if($ajaxName == "getLanguages") {
            $languages = [];
            $nlanguages = Language::all();

            foreach($nlanguages as $language) {
                $languages[$language->uid] = [
                    "value" => $language->uid,
                    "name" => $language->title
                ];
            }
            
            $pages = Page::all();
            foreach($pages as $page) {
                if(isset($languages[$page->lid])) {
                    unset($languages[$page->lid]);
                }
            }

            return json_encode($languages);
        }

        if($ajaxName == "getTranslateableLanguages") {
            $uid = $params["uid"];
            $page = Page::where("uid", $uid)->first();

            $languages = [];
            $nlanguages = Language::all();

            foreach($nlanguages as $language) {
                $languages[$language->uid] = [
                    "value" => $language->uid,
                    "name" => $language->title
                ];
            }

            $pages = Page::all();
            foreach($pages as $page) {
                if(isset($languages[$page->lid])) {
                    unset($languages[$page->lid]);
                }
            }

            return json_encode($languages);
        }
    }

    public function savePage($page)
    {
        $existingPage = Page::where("slugs", $page->slugs)->first();

        if(is_null($existingPage)) {
            $existingPage = Page::where("title", $page->title)->first();

            if(is_null($existingPage)) {
                if($page->save()) {
                    return json_encode([
                        "type" => "success",
                        "title" => "Page '" . $page->title . "' created",
                        "description" => "Successfully created '" . $page->title . "'"
                    ]);
                }

                return json_encode([
                    "type" => "error",
                    "title" => "New Page failed",
                    "description" => "An error occured while creating '" . $page->title . "'"
                ]);
            } else {
                return json_encode([
                    "type" => "error",
                    "title" => "Page exists",
                    "description" => "The page '" . $existingPage->title . "' has this title already!"
                ]);
            }
        } else {
            return json_encode([
                "type" => "error",
                "title" => "Page exists",
                "description" => "The page '" . $existingPage->title . "' has this URL already!"
            ]);
        }

        return null;
    }
}
