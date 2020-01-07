<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

$table = "centauri_news";

$columns = function(Blueprint $table) {
    $table->increments("uid");
    $table->integer("lid");
    $table->integer("hidden");
    $table->string("title");
    $table->string("author");
    $table->softDeletes();
    $table->timestamps();
};

if(!Schema::hasTable($table)) {
    Schema::create($table, $columns);
}
