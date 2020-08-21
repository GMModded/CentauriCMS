<?php

use \Centauri\CMS\Service\SQLService;

$table = "centauri_frontend_slideritem_buttons";

SQLService::createTable($table);

SQLService::createInlineRecordColumns($table);

SQLService::createColumn($table, "label", "string");
SQLService::createColumn($table, "link", "string");
SQLService::createColumn($table, "bgcolor", "string", ["default" => ""]);
