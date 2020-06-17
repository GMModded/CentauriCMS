<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Centauri;
use Centauri\CMS\Utility\PathUtility;
use Exception;

/**
 * Simply generates a link which points to the "/{controller}/{action}"
 * 
 * @method action
 * Usage:
 * <a href="{!! URIBladeHelper::action("Controller", "action") !!}">My link</a>
 * 
 * Example:
 * <form action="{!! URIBladeHelper::action("Backend", "login") !!}">...</form>
 * 
 * 
 * 
 * @method linkAction
 * ...
 */

class URIBladeHelper
{
    public static function action($controller, $action)
    {
        $backendURL = $GLOBALS["Centauri"]["Paths"]["BackendURL"];
        $url = $backendURL . "action/" . $controller . "/" . $action;

        return $url;
    }

    public static function linkAction($class, $action, $parameters = [], $pid = "CURRENT_PAGE")
    {
        $baseURL = config("app")["url"];

        $instance = new $class;
        $action .= "Action";

        if(!method_exists($instance, $action)) {
            throw new Exception("The method '" . $action . "' in the class '" . $class . "' doesn't exists!");
        }

        $slug = isset($parameters["slug"]) ? urlencode($parameters["slug"]) : "";
        $slug = str_replace("+", "-", $slug);

        if($slug == "") {
            $namespaceInstance = new $class;
            $controllerName = str_replace("Controller", "", $namespaceInstance->getShortName());

            $action = str_replace("Action", "", $action);

            $slug = $baseURL . "/" . $controllerName . "/" . $action;
        }

        $url = strtolower(url(url()->current() . "/$slug"));
        return $url;

        return call_user_func([
            $instance,
            $action
        ], $parameters);
    }
}
