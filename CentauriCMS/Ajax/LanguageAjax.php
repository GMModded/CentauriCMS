<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Traits\AjaxTrait;

class LanguageAjax
{
    use AjaxTrait;

    /**
     * Creation of new language-records.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function newLanguageAjax(Request $request)
    {
        $params = $request->input();

        $data = json_decode($params["data"], true);

        $title = $data["title"];
        $langcode = $data["langcode"];
        $slug = $data["slug"];

        $language = new Language;

        $language->title = $title;
        $language->lang_code = $langcode;
        $language->slug = $slug;
        $language->flagsrc = "";

        $saved = $language->save();

        if($saved) {
            return json_encode([
                "type" => "success",
                "title" => "Language '" . $title . "' created",
                "description" => "This language has been successfully created!"
            ]);
        }
    }

    /**
     * Edit of an existing language-record.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function editLanguageAjax(Request $request)
    {
        $params = $request->input();

        $uid = $params["uid"];
        $title = $params["title"];
        $url = $params["slug"];
        $langcode = $params["langcode"];

        $language = Language::where("uid", $uid)->get()->first();

        $language->title = $title;
        $language->slug = $url;
        $language->lang_code = $langcode;

        if($language->save()) {
            return json_encode([
                "type" => "success",
                "title" => "Language '" . $title . "' saved",
                "description" => "Successfully updated '" . $title . "'"
            ]);
        }

        return json_encode([
            "type" => "error",
            "title" => "Updating Language failed",
            "description" => "An error occured while updating '" . $title . "'"
        ]);
    }

    /**
     * Deleting an existing language-record.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deleteLanguageAjax(Request $request)
    {
        $params = $request->input();
        $uid = $params["uid"];

        $language = Language::where("uid", $uid)->get()->first();
        $title = $language->title;

        Language::destroy($uid);

        return json_encode([
            "type" => "warning",
            "title" => "Language '$title' deleted",
            "description" => "This language has been deleted"
        ]);
    }
}
