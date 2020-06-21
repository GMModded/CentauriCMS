<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "elements";
$SQLService->createColumn($table, "header", "string", ["nullable" => false, "default" => ""]);
$SQLService->createColumn($table, "htag", "string", ["nullable" => false, "default" => ""]);

$SQLService->createColumn($table, "slideritems", "integer", ["nullable" => true, "default" => 0]);
$SQLService->createColumn($table, "slideritems_buttons", "integer", ["nullable" => true, "default" => 0]);
