<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "slideritem_buttons";
$SQLService->createTable($table);

$SQLService->createInlineRecordColumns($table);

$SQLService->createColumn($table, "label", "string");
$SQLService->createColumn($table, "link", "string");
$SQLService->createColumn($table, "bgcolor", "string", ["default" => ""]);
