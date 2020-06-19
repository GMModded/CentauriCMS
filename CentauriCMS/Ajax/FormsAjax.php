<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\Form;
use Illuminate\Http\Request;

class FormsAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "create") {
            $name = $request->input("name");

            $form = new Form;
            $form->name = $name;
            $form->save();

            return json_encode([
                "type" => "success",
                "title" => "Forms",
                "description" => "Form '" . $name . "' has been created"
            ]);
        }

        if($ajaxName == "edit") {
            $uid = $request->input("uid");
            $form = Form::where("uid", $uid)->get()->first();

            $tabs = config("centauri")["forms"]["tabs"];
            $data = [
                "tabs" => $tabs
            ];

            $html = view("Centauri::Backend.Modules.forms.edit", [
                "form" => $form,
                "data" => $data
            ])->render();

            return [
                "form" => $form,
                "html" => $html
            ];
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
