<?php
namespace Centauri\CMS;

class AjaxAbstract
{
    public static function default($request, $ajaxName)
    {
        return json_encode([
            "type" => "error",
            "title" => "Internal Server Error (AJAX)",
            "description" => "There's no handling for the action <b><u>" . $ajaxName . "</u></b>"
        ]);
    }
}
