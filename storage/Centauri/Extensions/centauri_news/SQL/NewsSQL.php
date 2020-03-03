<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "centauri_news";
$SQLService->createTable($table);

$SQLService->createColumn($table, "hidden", "integer", ["default" => 0]);
$SQLService->createColumn($table, "headerimage", "integer", ["default" => null]);
$SQLService->createColumn($table, "title", "string", ["default" => ""]);
$SQLService->createColumn($table, "author", "string", ["default" => ""]);
