<?php

error_reporting(E_ALL);
ini_set("display_errors", "On");

/**
 * CentauriCMS v7 - Content Management System made using Laravel 7
 * 
 * @package CentauriCMS
 */
include_once __DIR__ . "/CentauriCMS/Application/CentauriApplication.php";

$Centauri = new \Centauri\CMS\Application\CentauriApplication();
$Centauri = $Centauri->Centauri;


/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

$uri = urldecode(
    parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH)
);

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if($uri !== "/" && file_exists(__DIR__ . "/public" . $uri)) {
    return false;
}

require_once __DIR__ . "/public/index.php";
