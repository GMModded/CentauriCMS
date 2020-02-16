<?php

// $SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

// $table = "elements";

// $SQLService->createColumn($table, "htag", "string");

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "elements";
$SQLService->createTable($table);

$SQLService->createColumn($table, "htag", "string", "");
$SQLService->createColumn($table, "slideritems", "integer", 0);
$SQLService->createColumn($table, "slideritems_buttons", "integer", 0);
