<?php

use Centauri\CMS\Caches\StaticFileCache;
use Centauri\CMS\Centauri;
use Centauri\CMS\CentauriServer;
use Centauri\CMS\CentauriServer\KernelLevelCaching;
use Centauri\CMS\Utility\PathUtility;

define("CENTAURI_START", microtime(true));


/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

define("LARAVEL_START", microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__ . "/../vendor/autoload.php";


/**
 * CentauriCMS - Server-Level-Configuration
 * 
 * This configuration handling will take care before actual web-/http-requests are sent to the server.
 * Those could be for use when e.g. making a Kernel-Level-Caching (as below) or anything similiar.
 */
$centauriServer = Centauri::makeInstance(CentauriServer::class);

$centauriServerConfig = $centauriServer->init();

if(
    $centauriServerConfig["KERNEL_LEVEL_CACHING"]["status"] &&
    $centauriServerConfig["KERNEL_LEVEL_CACHING"]["__handle"]
) {
    return;
}

/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__ . "/../bootstrap/app.php";

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

/**
 * CentauriCMS - Kernel-Level-Caching
 * 
 * The cache will only be set if the config for this is active (manually) to true and it's not filtered.
 */
if($centauriServerConfig["KERNEL_LEVEL_CACHING"]["status"]) {
    $kernelLevelCaching = Centauri::makeInstance(KernelLevelCaching::class);

    if(!$kernelLevelCaching->cachableRequestUri()) {
        StaticFileCache::setCacheKernel(
            PathUtility::getRequestedURL(),
            $response->getContent()
        );
    }
}

$response->send();

$kernel->terminate($request, $response);
