<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Utility\DomainsUtility;

class PageAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        $params = $request->input();

        if($ajaxName == "newPage") {
            $data = json_decode($params["data"], true);

            $parentuid = $data["parent"];

            $page = new Page;
            $page->pid = $parentuid;
            $page->title = $data["title"];
            $page->page_type = $data["page_type"];
            $page->backend_layout = $data["be_layout"] ?? "";
            $page->page_type = $data["page_type"];

            if($page->backend_layout == "") {
                return response("Backend-Layout can't be an empty string!", 500);
            }

            $url = $data["url"];
            $page->lid = $data["language"];

            if($data["page_type"] == "rootpage") {
                // if(!$request->has("language")) {
                //     return response("Selected language is not available as a rootpage!", 500);
                // }

                $page->slugs = $url;
            } else {
                $parentPage = Page::where("uid", $parentuid)->get()->first();

                $page->lid = $parentPage->lid;
                $page->slugs = $data["url"] ?? "/";
                // $page->storage_id = $parentPage->uid;
            }

            return $this->savePage($page);
        }

        if($ajaxName == "updatePage") {
            $uid = $params["uid"];
            $dataArr = json_decode($params["data"], true);

            $excludedArr = [
                "uid",
                "pid",
                "lid",
                "created_at",
                "updated_at",
                "deleted_at"
            ];

            $page = Page::where("uid", $uid)->get()->first();

            foreach($dataArr as $id => $value) {
                $page->setAttribute($id, $value);
            }

            if($page->save()) {
                return json_encode([
                    "type" => "success",
                    "title" => "Page '" . $page->title . "' saved",
                    "description" => "Successfully updated '" . $page->title . "'"
                ]);
            }

            return json_encode([
                "type" => "error",
                "title" => "Updating Page failed",
                "description" => "An error occured while updating '" . $page->title . "'"
            ]);
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
            $pages = Page::where("page_type", "rootpage")->orWhere("page_type", "storage")->get();

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

            return json_encode($languages);

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

        if($ajaxName == "findByUid") {
            $uid = $params["uid"];
            $page = Page::where("uid", $uid)->get()->first();

            return json_encode($page);
        }
    }

    /**
     * Method which try to save a given Page Model and handles a properly json response.
     * 
     * @return json
     */
    public function savePage($page)
    {
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
    }
}
