<?php

/**
 * SQLService
 */
$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

/**
 * Table
 */
$table = "forms";
$SQLService->createTable($table);

/**
 * Columns
 */
$SQLService->createColumn($table, "name", "string", ["nullable" => false]);
$SQLService->createColumn($table, "config", "binary", ["nullable" => true, "default" => null]);
