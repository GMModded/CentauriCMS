<?php

$table = "cookies";
\SQLService::createTable($table);

\SQLService::createInlineRecordColumns($table);

\SQLService::createColumn($table, "name", "string");
\SQLService::createColumn($table, "teaser", "text");
\SQLService::createColumn($table, "state", "tinyInteger");
\SQLService::createColumn($table, "cookies", "integer");
