<?php
namespace Centauri\CMS\Ajax;

use App\Language;
use Centauri\CMS\AjaxInterface;
use Illuminate\Http\Request;
use App\Page;
use Centauri\CMS\Centauri;
use Centauri\CMS\Service\PageService;

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
            $title = $params["title"];
            $url = $params["url"];

            // $page = new Page;

            // $page->title = $title;
            // $page->slugs = $url;
            // $page->backend_layout = 1;
            // $page->is_rootpage = 1;
            // $page->lid = 1;

            $page = $this->pageService->createNewPage([
                "title" => $title,
                "slugs" => $url,
                "backend_layout" => 1,
                "is_rootpage" => 1,
                "lid" => 1
            ]);

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

        return json_encode([
            "request" => "'$ajaxName' is invalid."
        ]);
    }
}
