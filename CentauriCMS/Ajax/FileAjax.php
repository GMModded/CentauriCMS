<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Model\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class FileAjax implements AjaxInterface
{
    protected $cropableArray = [
        "png",
        "jpg",
        "jpeg",
        "tif",
        "gif"
    ];

    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "upload") {
            $fileMimeTypeUtil = Centauri::makeInstance(\Centauri\CMS\Utility\FileMimeTypeUtility::class);

            $file = $request->file;
            $name = $request->input("name");
            $mimeType = $file->getClientMimeType();
            $fileExtension = $fileMimeTypeUtil->getExtByMimeType($mimeType);

            $file = $request->file->storeAs("public", "$name.$fileExtension");
            rename(storage_path("app/$file"), storage_path("Centauri\\Filelist\\$name.$fileExtension"));

            $fileModel = new File();

            $fileModel->name = "$name.$fileExtension";
            $fileModel->type = $mimeType;
            $fileModel->path = env("APP_URL") . "/storage/Centauri/Filelist/$name.$fileExtension";
            $fileModel->cropable = in_array($fileExtension, $this->cropableArray) ? 1 : 0;

            try {
                $fileModel->save();
            } catch(\Exception $e) {
                echo $e->getMessage();
            }
        }

        if($ajaxName == "edit") {
            $uid = $request->input("uid");
            $oldName = $request->input("oldName");
            $name = $request->input("name");

            $file = File::where("uid", $uid)->get()->first();
            $file->name = $name;

            $file->save();
            rename(storage_path("Centauri\\Filelist\\$oldName"), storage_path("Centauri\\Filelist\\$name"));

            return json_encode([
                "type" => "success",
                "title" => "Filelist - File updated",
                "description" => "This file has been updated"
            ]);
        }

        if($ajaxName == "crop") {
            $image = $request->image;
            $name = $request->input("name");
            $mimeType = $image->getClientMimeType();

            if(file_exists(storage_path("Centauri/Filelist/$name"))) {
                return json_encode([
                    "type" => "error",
                    "title" => "Filelist - Crop",
                    "description" => "An image with this name exists already!"
                ]);
            }

            $fileModel = new File();

            $fileModel->name = $name;
            $fileModel->type = $mimeType;
            $fileModel->path = env("APP_URL") . "/storage/Centauri/Filelist/" . $name;
            $fileModel->cropable = 1;

            $fileModel->save();

            $image = $request->image->storeAs("public", $name);
            rename(storage_path("app\\$image"), storage_path("Centauri\\Filelist\\$name"));
        }

        if($ajaxName == "delete") {
            $uid = $request->input("uid");

            $file = File::where("uid", $uid)->get()->first();
            $name = $file->name;
            $path = $file->path;
            $file->delete();

            if(file_exists($path)) {
                unlink($path);
            }

            return json_encode([
                "type" => "warning",
                "title" => "Filelist - Deleted file",
                "description" => "The file '" . $name . "' has been deleted"
            ]);
        }

        if($ajaxName == "list") {
            $value = $request->input("value");
            $type = $request->input("type");

            $list = File::get()->all();

            if($type == "images") {
                $list = File::where("cropable", 1)->get()->all();
            }

            $uidArr = [];
            if(Str::contains($value, ",")) {
                $uidArr = explode(",", $value);
            } else {
                $uidArr = [$value];
            }

            return view("Centauri::Backend.Modals.filelist", [
                "list" => $list,
                "uidArr" => $uidArr
            ])->render();
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
