<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command("inspire", function () {
    $this->comment(Inspiring::quote());
    Log::info("INSPIREDDDD . " . now());
})->describe("Display an inspiring quote");


Artisan::command("testcommand", function() {
    Log::info("WOW");
});
