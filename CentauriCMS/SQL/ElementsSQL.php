<?php

// $SQLService->createColumn($table, "htag", "string");

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "elements";
$SQLService->createTable($table);

$SQLService->createColumn($table, "subheader", "string", ["nullable" => true]);
$SQLService->createColumn($table, "RTE", "text", ["nullable" => true]);
$SQLService->createColumn($table, "htag", "string", ["nullable" => false, "default" => ""]);
$SQLService->createColumn($table, "slideritems", "string", ["nullable" => false, "default" => 0]);
$SQLService->createColumn($table, "slideritems_buttons", "string", ["nullable" => false, "default" => 0]);
$SQLService->createColumn($table, "grid", "string", ["nullable" => true, "default" => null]);
