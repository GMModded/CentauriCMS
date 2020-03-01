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
$SQLService->createColumn($table, "grids_sorting", "integer", ["nullable" => true]);
