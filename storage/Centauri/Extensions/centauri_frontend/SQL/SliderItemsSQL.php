<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "centauri_frontend_slideritems";
$SQLService->createTable($table);

$SQLService->createInlineRecordColumns($table);

$SQLService->createColumn($table, "image", "integer", ["nullable" => true]);
$SQLService->createColumn($table, "title", "string", ["nullable" => true]);
$SQLService->createColumn($table, "teasertext", "text", ["nullable" => true]);
$SQLService->createColumn($table, "link", "string", ["nullable" => true]);
$SQLService->createColumn($table, "bgcolor", "string", ["nullable" => true]);
