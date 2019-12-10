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
            $parentuid = $params["parentuid"] ?? null;
            $is_rootpage = $params["is_rootpage"] ?? false;

            $page = new Page;

            $title = $params["title"];
            $url = $params["url"];

            if($is_rootpage) {
                $page->pid = $parentuid;
                $page->lid = $params["language"];
                $page->backend_layout = 1;
                $page->is_rootpage = 1;
                $page->title = $title;
                $page->slugs = $url;
            } else {
                $parentPage = Page::where("uid", $parentuid)->get()->first();

                if(is_null($parentPage)) {
                    return json_encode([
                        "type" => "error",
                        "title" => "Parent page not found",
                        "description" => "Please refresh or abort the current action."
                    ]);
                }

                $page->pid = $parentuid;
                $page->lid = $params["language"];
                $page->backend_layout = 1;
                $page->is_rootpage = 1;

                $page->title = $title;
                $page->slugs = $params["url"] ?? "/";
            }

            $existingPage = Page::where("slugs", $url)->first();

            if(is_null($existingPage)) {
                $existingPage = Page::where("title", $title)->first();

                if(is_null($existingPage)) {
                    if($page->save()) {
                        return json_encode([
                            "type" => "success",
                            "title" => "Page '" . $title . "' created",
                            "description" => "Successfuly created '" . $title . "'"
                        ]);
                    }

                    return json_encode([
                        "type" => "error",
                        "title" => "New Page failed",
                        "description" => "An error occured while creating '" . $title . "'"
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
        }

        if($ajaxName == "editPage") {
            $uid = $params["uid"];

            $title = $params["title"];
            $url = $params["url"];

            $page = Page::find($uid);

            $page->title = $title;
            $page->slugs = $url;

            if($page->save()) {
                return json_encode([
                    "type" => "success",
                    "title" => "Page '" . $title . "' saved",
                    "description" => "Successfuly updated '" . $title . "'"
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
            $page = Page::find($uid);

            $url = $page->slugs;
            return $url;
        }

        if($ajaxName == "deletePage") {
            $uid = $params["uid"];

            $page = Page::find($uid);
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

            $page = Page::find($uid);

            $newPage = $page->replicate();
            $newPage->title = $title;
            $newPage->slugs = $url;
            $newPage->lid = $lid;
            $newPage->push();

            $language = Language::find($lid);

            return json_encode([
                "type" => "success",
                "title" => "Page '$title' translated to " . $language->lang_code,
                "description" => "This page has successfuly been translated"
            ]);
        }

        if($ajaxName == "getRootPages") {
            $pages = Page::where("is_rootpage", "1")->get();

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
            $nlanguages = Language::all();
            $languages = [];

            foreach($nlanguages as $language) {
                $languages[] = [
                    "value" => $language->uid,
                    "name" => $language->title
                ];
            }

            return json_encode($languages);
        }

        if($ajaxName == "getTranslateableLanguages") {
            $uid = $params["uid"];
            $page = Page::where("uid", $uid)->first();

            $nlanguages = Language::all()->filter(function($language) use ($page) {
                if(!is_null($page)) {
                    dump($language->uid);
                    dump($page->lid);

                    if($language->uid != $page->lid) {
                        return $language;
                    }
                } else {
                    return $language;
                }
            });

            $languages = [];

            foreach($nlanguages as $language) {
                $languages[] = [
                    "value" => $language->uid,
                    "name" => $language->title
                ];
            }

            return json_encode($languages);
        }

        return json_encode([
            "request" => "'$ajaxName' is invalid."
        ]);
    }
}
