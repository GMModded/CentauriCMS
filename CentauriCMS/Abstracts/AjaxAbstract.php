<?php
namespace Centauri\CMS\Abstracts;

class AjaxAbstract
{
    /**
     * Default response when an ajax-request-method isn't returning properly.
     * 
     * @param Request $request The request object given by Laravel itself.
     * @param string $ajaxName The method to be called ("mymethod" . "Ajax" (would be "mymethodAjax")) in the respective class.
     * 
     * @return response
     */
    public static function default($request, $ajaxName, $message = "There's no AJAX-handling for the action <b><u>{AJAX_NAME}</u></b>")
    {
        $message = str_replace("{AJAX_NAME}", $ajaxName, $message);
        return response($message, 500);
    }
}
