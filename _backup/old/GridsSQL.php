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
$SQLService->createColumn($table, "grid", "string", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grids_parent", "integer", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grids_sorting_rowpos", "integer", ["nullable" => true]);
$SQLService->createColumn($table, "grids_sorting_colpos", "integer", ["nullable" => true]);

$SQLService->createColumn($table, "grid_container_fullwidth", "string", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grid_space_top", "string", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grid_space_left", "string", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grid_space_bottom", "string", ["nullable" => true, "default" => null]);
$SQLService->createColumn($table, "grid_space_right", "string", ["nullable" => true, "default" => null]);
