<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "elements";
$SQLService->createColumn($table, "header", "string", ["nullable" => false, "default" => ""]);
$SQLService->createColumn($table, "htag", "string", ["nullable" => false, "default" => ""]);

$SQLService->createColumn($table, "slideritems", "string", ["nullable" => false, "default" => 0]);
$SQLService->createColumn($table, "slideritems_buttons", "string", ["nullable" => false, "default" => 0]);
