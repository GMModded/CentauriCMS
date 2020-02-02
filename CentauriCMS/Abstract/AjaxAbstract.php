<?php
namespace Centauri\CMS;

class AjaxAbstract
{
    public static function default($request, $ajaxName)
    {
        return response("There's no AJAX-handling for the action <b><u>" . $ajaxName . "</u></b>", 500);
    }
}
