<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Model\File;
use Centauri\CMS\Model\FileReference;
use \Illuminate\Http\Request;
use Centauri\CMS\Traits\AjaxTrait;

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
    public function saveCroppedDataByUidAjax(Request $request)
    {
        $fileReferenceUid = $request->input("fileReferenceUid");

        $fileReference = FileReference::where("uid", $fileReferenceUid)->get()->first();
        $fileReference->data = $request->input("data");

        echo "<img src='" . $request->input("data")["base64"] . "' class='img-fluid' />";

        if($fileReference->save()) {
            return json_encode([
                "type" => "success",
                "title" => "Image-Cropper",
                "description" => "Cropping of this image has been saved"
            ]);
        }

        return response("Something failed while saving this image (File-Reference) with cropping data", 500);
    }
}
