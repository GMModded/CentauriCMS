<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "slideritems";
$SQLService->createTable($table);

$SQLService->createColumn($table, "image", "integer", [
    "nullable" => true
]);

$SQLService->createColumn($table, "title", "string");
$SQLService->createColumn($table, "teasertext", "text");
