<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\File;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ImageModalAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "list") {
            $images = File::where("cropable", 1)->get()->all();
            $value = $request->input("value");

            $uidArr = [];
            if(Str::contains($value, ",")) {
                $uidArr = explode(",", $value);
            } else {
                $uidArr = [$value];
            }

            return view("Centauri::Backend.Modals.imageslist", [
                "images" => $images,
                "uidArr" => $uidArr
            ])->render();
        }
    }
}
