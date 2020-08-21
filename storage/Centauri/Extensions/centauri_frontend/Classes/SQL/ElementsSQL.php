<?php

use \Centauri\CMS\Service\SQLService;

$table = "elements";

SQLService::createColumn($table, "header", "string", ["nullable" => false, "default" => ""]);
SQLService::createColumn($table, "htag", "string", ["nullable" => false, "default" => ""]);

SQLService::createColumn($table, "slideritems", "integer", ["nullable" => true, "default" => 0]);
SQLService::createColumn($table, "slideritems_buttons", "integer", ["nullable" => true, "default" => 0]);

SQLService::createColumn($table, "bgoverlayer", "string", ["nullable" => false, "default" => ""]);
