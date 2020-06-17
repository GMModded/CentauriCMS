<?php

$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

/**
 * Table: be_roles
 */
$table = "be_roles";
$SQLService->createTable($table);

$SQLService->createColumn($table, "name", "string", ["nullable" => false]);
$SQLService->createColumn($table, "description", "string", ["nullable" => false]);
$SQLService->createColumn($table, "permissions", "binary", ["nullable" => true, "default" => null]);



/**
 * Table: be_permissions
 */
$table = "be_permissions";
$SQLService->createTable($table);

$SQLService->createColumn($table, "name", "string", ["nullable" => false]);
$SQLService->createColumn($table, "description", "string", ["nullable" => true, "default" => null]);
