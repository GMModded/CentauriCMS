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

        if($ajaxName == "editLanguage") {
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

        return response("LanguageAjax - the action '" . $ajaxName . "' doesn't exists!", 500);
    }
}
