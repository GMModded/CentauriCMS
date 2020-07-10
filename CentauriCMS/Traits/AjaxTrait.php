<?php
namespace Centauri\CMS\Traits;

use Centauri\CMS\Abstracts\AjaxAbstract;
use Centauri\CMS\Centauri;
use Error;
use ErrorException;
use Illuminate\Http\Request;

trait AjaxTrait
{
    /**
     * Request Method - handles method for ajax's by $ajaxName.
     * 
     * @param Request $request The HTTP request object.
     * @param string $ajaxName The ajax id/name to handle it.
     * 
     * @return void
     */
    public function request(Request $request, String $ajaxName)
    {
        $ajaxName = $ajaxName . "Ajax";

        try {
            return $this->$ajaxName($request);
        } catch(ErrorException $e) {
            if(!Centauri::keepSiteAlive()) {
                throw $e;
            }
        } catch(Error $e) {
            if(!Centauri::keepSiteAlive()) {
                throw $e;
            }
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
