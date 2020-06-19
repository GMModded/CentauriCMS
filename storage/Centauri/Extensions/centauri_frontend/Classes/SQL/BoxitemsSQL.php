<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "centauri_frontend_boxitems";
$SQLService->createTable($table);

$SQLService->createInlineRecordColumns($table);

$SQLService->createColumn($table, "icon", "integer", ["nullable" => true]);
$SQLService->createColumn($table, "link", "string", ["nullable" => true]);
$SQLService->createColumn($table, "link_label", "string", ["nullable" => true]);
$SQLService->createColumn($table, "header", "string", ["nullable" => true]);
$SQLService->createColumn($table, "description", "text", ["nullable" => true]);
$SQLService->createColumn($table, "col_desktop", "string", ["default" => "3"]);
$SQLService->createColumn($table, "bgcolor_start", "string", ["nullable" => true]);
$SQLService->createColumn($table, "bgcolor_end", "string", ["nullable" => true]);
