<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "elements";
$SQLService->createTable($table);

$SQLService->createColumn($table, "pid", "integer");
$SQLService->createColumn($table, "hidden", "integer", ["default" => 0]);
$SQLService->createColumn($table, "plugin", "string", ["nullable" => true, "default" => ""]);
$SQLService->createColumn($table, "header", "string", ["nullable" => false, "default" => ""]);
$SQLService->createColumn($table, "subheader", "string", ["nullable" => false, "default" => ""]);
$SQLService->createColumn($table, "RTE", "text", ["nullable" => false]);
$SQLService->createColumn($table, "file", "integer", ["nullable" => true]);
$SQLService->createColumn($table, "image", "integer", ["nullable" => true]);
