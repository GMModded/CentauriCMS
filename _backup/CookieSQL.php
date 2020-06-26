<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "centauri_cookie";

$SQLService->createTable($table);

$SQLService->createColumn($table, "name", "string", ["default" => ""]);
$SQLService->createColumn($table, "description", "text", ["default" => ""]);
$SQLService->createColumn($table, "cookies", "integer", ["nullable" => true, "default" => 0]);
