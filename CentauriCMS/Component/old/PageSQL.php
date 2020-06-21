<?php

/**
 * SQLService
 */
$SQLService = \Centauri\CMS\Centauri::makeInstance(\Centauri\CMS\Service\SQLService::class);

/**
 * Table
 */
$table = "pages";

/**
 * Columns
 */
$SQLService->createColumn($table, "domain_id", "integer", ["default" => null, "nullable" => true]);
$SQLService->createColumn($table, "storage_id", "integer", ["default" => null, "nullable" => true]);


$SQLService->createColumn($table, "page_type", "string");

$SQLService->createColumn($table, "seo_keywords", "string", ["default" => ""]);
$SQLService->createColumn($table, "seo_description", "string", ["default" => ""]);
$SQLService->createColumn($table, "seo_robots_indexpage", "boolean", ["default" => true]);
$SQLService->createColumn($table, "seo_robots_followpage", "boolean", ["default" => true]);

$SQLService->createColumn($table, "hidden_inpagetree", "boolean", ["default" => false]);
