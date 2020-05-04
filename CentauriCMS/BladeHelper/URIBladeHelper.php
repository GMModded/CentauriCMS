<?php
namespace Centauri\CMS\BladeHelper;

use Exception;

/**
 * Usage:
 * <a href="{!! URIBladeHelper::action("Controller", "action") !!}">My link</a>
 * 
 * Example:
 * <form action="{!! URIBladeHelper::action("Backend", "login") !!}">...</form>
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

    public static function linkAction($class, $action, $parameters, $pid = "CURRENT_PAGE")
    {
        $instance = new $class;
        $action .= "Action";

        if(!method_exists($instance, $action)) {
            throw new Exception("The method '" . $action . "' in the class '" . $class . "' doesn't exists!");
        }

        $slug = isset($parameters["slug"]) ? urlencode($parameters["slug"]) : "";
        $slug = str_replace("+", "-", $slug);
        $url = strtolower(url(url()->current() . "/$slug"));

        return $url;

        return call_user_func([
            $instance,
            $action
        ], $parameters);
    }
}
