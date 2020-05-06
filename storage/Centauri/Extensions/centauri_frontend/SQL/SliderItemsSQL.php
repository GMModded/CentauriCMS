<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

$table = "slideritems";
$SQLService->createTable($table);

$SQLService->createColumn($table, "image", "integer", ["nullable" => true]);
$SQLService->createColumn($table, "title", "text", ["nullable" => true]);
$SQLService->createColumn($table, "teasertext", "text", ["nullable" => true]);
$SQLService->createColumn($table, "sorting", "integer");
$SQLService->createColumn($table, "parent_uid", "integer");
