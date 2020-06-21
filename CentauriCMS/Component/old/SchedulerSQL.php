<?php

/**
 * SQLService
 */
$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

/**
 * Table
 */
$table = "schedulers";
$SQLService->createTable($table, false);

/**
 * Columns
 */
$SQLService->createColumn($table, "name", "string", ["nullable" => false]);
$SQLService->createColumn($table, "namespace", "string", ["nullable" => false]);
$SQLService->createColumn($table, "last_runned", "string", ["nullable" => false]);
$SQLService->createColumn($table, "state", "string", ["nullable" => false, "default" => "-"]);
$SQLService->createColumn($table, "time", "string", ["nullable" => false]);
