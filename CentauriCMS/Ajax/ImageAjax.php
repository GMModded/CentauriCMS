<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\File;
use Centauri\CMS\Model\FileReference;
use \Illuminate\Http\Request;
use Centauri\CMS\Traits\AjaxTrait;
use Centauri\CMS\Utility\PathUtility;
use Illuminate\Support\Facades\Storage;

class ImageAjax
{
    use AjaxTrait;

    /**
     * 
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function cropByUidAjax(Request $request)
    {
        $fileReferenceUid = $request->input("fileReferenceUid");
        $fileReference = FileReference::where("uid", $fileReferenceUid)->get()->first();

        $file = File::where("uid", $fileReference->uid_image)->get()->first();

        return view("Centauri::Backend.Ajax.Image.cropping", [
            "fileReference" => $fileReference,
            "file" => $file
        ])->render();
    }

    /**
     * 
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function cropImageAjax(Request $request)
    {
        $image = $request->image;
        $mimeType = $image->getClientMimeType();

        $fileReferenceUid = $request->input("fileReferenceUid");
        $data = $request->input("data");
        $fileName = $request->input("fileName");
        $view = $request->input("view");

        $imageExt = explode("/", $mimeType)[1];

        $imageFileName = $fileName . "." . $imageExt;

        if($view != "default") {
            $imageFileName = $view . "_" . $imageFileName;
        }

        Storage::disk("centauri_filelist")->put(
            "cropped/" . $imageFileName,

            base64_decode(
                explode(
                    "base64,",
                    $image->get()
                )[1]
            )
        );

        $fileReference = FileReference::where("uid", $fileReferenceUid)->get()->first();

        if(is_null($fileReference->data)) {
            $dataArr[$view] = json_decode($data, true);
        } else {
            $dataArr[$view] = json_decode($data, true);
            $dataArr = array_merge(json_decode($fileReference->data, true), $dataArr);
        }

        $fileReference->data = json_encode($dataArr);

        $pathUtility = Centauri::makeInstance(PathUtility::class);
        $newImagePath = $pathUtility->getBaseURL("storage/Centauri/Filelist/cropped/" . $imageFileName);

        /*
        $exists = Storage::disk("centauri_filelist")->exists("cropped/$imageFileName");
        if($exists) {
            return response("The cropped image with the name '$imageFileName' already exists!", 500);
        }
        */

        $file = new File;

        $file->name = $fileName;
        $file->path = $newImagePath;
        $file->type = $mimeType;
        $file->cropable = 1;

        if($fileReference->save() && $file->save()) {
            echo json_encode([
                "type" => "success",
                "title" => "Image-Cropper",
                "description" => "Cropping of this Image has been saved"
            ]);

            return json_encode([
                "type" => "success",
                "title" => "Image-Cropper",
                "description" => "Cropping of this image has been saved"
            ]);
        }

        echo "FALSE";
        return response("Something failed while saving this image (File-Reference) with cropping data", 500);
    }
}
