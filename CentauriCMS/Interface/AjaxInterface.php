<?php
namespace Centauri\CMS;

use Illuminate\Http\Request;

interface AjaxInterface
{
    /**
     * request method for incoming AJAX-POST calls
     * 
     * @param Request &$request
     * 
     * @return void
     */
    public function request(Request $request, String $ajaxName);
}
