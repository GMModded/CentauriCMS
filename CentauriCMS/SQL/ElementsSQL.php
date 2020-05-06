<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "elements";
$SQLService->createTable($table);

$SQLService->createColumn($table, "pid", "integer");
$SQLService->createColumn($table, "hidden", "integer", ["default" => 0]);
$SQLService->createColumn($table, "plugin", "string", ["nullable" => true, "default" => ""]);
$SQLService->createColumn($table, "file", "string", ["nullable" => true, "default" => ""]);
