<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "centauri_news";
$SQLService->createTable($table);

$SQLService->createColumn($table, "headerimage", "integer", ["default" => null]);
$SQLService->createColumn($table, "title", "string", ["default" => ""]);
$SQLService->createColumn($table, "author", "string", ["default" => ""]);
$SQLService->createColumn($table, "description", "text", "", ["default" => null]);
$SQLService->createColumn($table, "slug", "string", "", ["default" => ""]);
