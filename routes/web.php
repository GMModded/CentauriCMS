<?php
use Centauri\CMS\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("/", function() {
    return Request::handle("/");
});

Route::get("{nodes}", function($nodes = []) {
    return Request::handle($nodes);
})->where(["nodes" => ".*"]);

Route::post("{nodes}", function($nodes = []) {
    return Request::handle($nodes);
})->where(["nodes" => ".*"]);
