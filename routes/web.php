<?php
use Centauri\CMS\Http\Request;

Route::any("{nodes}", function($nodes = []) {
    $host = request()->getHost();
    $host = str_replace("www.", "", $host);

    $splittedHost = explode(".", $host);

    if(count($splittedHost) >= 3) {
        return Request::handle($nodes, $host, "subdomain");
    }

    if(empty($nodes)) {
        return Request::handle($nodes, $host);
    }

    return Request::handle($nodes, $host);
})->where(["nodes" => ".*"]);
