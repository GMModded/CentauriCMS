<?php

/**
 * SQLService
 */
$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

/**
 * Table
 */
$table = "elements";

/**
 * Columns
 */
$SQLService->createColumn($table, "grids_parent", "integer", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grids_sorting_rowpos", "integer", ["nullable" => true]);
$SQLService->createColumn($table, "grids_sorting_colpos", "integer", ["nullable" => true]);
