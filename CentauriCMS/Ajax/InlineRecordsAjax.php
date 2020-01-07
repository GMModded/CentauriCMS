<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\File;
use Illuminate\Support\Str;

class InlineRecordsAjax implements AjaxInterface
{
    public function request(\Illuminate\Http\Request $request, string $ajaxName)
    {
        if($ajaxName == "list") {
            $type = $request->input("type");

            if($type == "files") {
                $uids = $request->input("uids");

                if(Str::contains($uids, ",")) {
                    $uids = explode(",", $uids);
                } else {
                    $uids = [$uids];
                }

                $files = [];

                foreach($uids as $uid) {
                    $files[] = File::where("uid", $uid)->get()->first();
                }

                return view("Centauri::Backend.Modals.inlineRecords", [
                    "type" => $type,
                    "files" => $files
                ]);
            }
        }
    }
}
