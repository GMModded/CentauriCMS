<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Traits\AjaxTrait;

class PageAjax
{
    use AjaxTrait;

    /**
     * Creation of a new page-record.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function newPageAjax(Request $request)
    {
        $params = $request->input();

        $data = json_decode($params["data"], true);

        $parentuid = null;
        if($data["page_type"] ?? "rootpage" != "rootpage") {
            if(isset($data["parent"])) {
                $parentuid = $data["parent"];
            }
        }

        $page = new Page;
        $page->pid = $parentuid ?? 0;
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

            $page->lid = $parentPage->lid ?? 1;
            $page->slugs = $data["url"] ?? "/";
            // $page->storage_id = $parentPage->uid;
            $page->domain_id = $parentPage->uid;
        }

        return $this->savePage($page);
    }

    /**
     * Updates a page-record by its uid and data-array (from json, from client-side, to array at server-side).
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function updatePageAjax(Request $request)
    {
        $params = $request->input();

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

    /**
     * Edits a page by its uid and saves it.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function editPageAjax(Request $request)
    {
        $params = $request->input();

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

    /**
     * Returns the page absolute url.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return string
     */
    public function showPageAjax(Request $request)
    {
        $params = $request->input();

        $uid = $params["uid"];
        $page = Page::where("uid", $uid)->get()->first();

        $url = $page->slugs;
        return $url;
    }

    /**
     * Deletes a page by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deletePageAjax(Request $request)
    {
        $params = $request->input();

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

    /**
     * Returns all existing rootpages of this application.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function getRootPagesAjax(Request $request)
    {
        $params = $request->input();

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

    /**
     * Returns all available languages of this application.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function getLanguagesAjax(Request $request)
    {
        $params = $request->input();

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

    /**
     * Returns all translateable languages by a specific page its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function getTranslateableLanguagesAjax(Request $request)
    {
        $params = $request->input();

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

    /**
     * Finds and returns the page-record model as json by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findByUidAjax(Request $request)
    {
        $params = $request->input();

        $uid = $params["uid"];
        $page = Page::where("uid", $uid)->get()->first();

        return json_encode($page);
    }

    /**
     * Helper-Method which attempts to save the given page-model and handles a properly json response as return.
     * 
     * @param \Page $page
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
