<?php

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ExtensionsComponent;

// Loading all extensions
Centauri::makeInstance(ExtensionsComponent::class)->loadExtensions();

// In case there's no extension which extends routing and/or adds custom routes setting
// $routes to an empty array.
$routes = $GLOBALS["Centauri"]["Handlers"]["routes"] ?? [];

foreach($routes as $key => $routeFn) {
    if(is_array($routes[$key])) {
        $_routes = $routes[$key][key($routes[$key])];

        $foreached = false;

        foreach($_routes as $_routeFn) {
            $_routeFn();
            $foreached = true;
        }

        if(!$foreached) {
            throw new Exception("The route with key '" . $key . "' must be an array with unique keys for reach route!");
        }
    }
}
