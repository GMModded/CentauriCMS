<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\File;
use Centauri\CMS\Utility\PathUtility;

/**
 * Usage:
 * <a href="{!! URIBladeHelper::action("") !!}">My link</a>
 * <form action="{!! URIBladeHelper::action("") !!}">...</form>
 * 
 * 
 */

class URIBladeHelper
{
    public static function action($controller, $action)
    {
        $backendURL = $GLOBALS["Centauri"]["Paths"]["BackendURL"];
        $url = $backendURL . "action/" . $controller . "/" . $action;

        return $url;
    }
}
