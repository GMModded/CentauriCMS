<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\Language;

class LanguageAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        $params = $request->input();

        if($ajaxName == "newLanguage") {
            $title = $params["title"];
            $langcode = $params["langcode"];
            $slug = $params["slug"];

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

        if($ajaxName == "deleteLanguage") {
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

        return response("LanguageAjax - an action like '" . $ajaxName . "' doesn't exists!", 500);
    }
}
