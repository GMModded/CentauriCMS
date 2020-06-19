<?php
namespace Centauri\Extension\Frontend\Scheduler;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class TablesLastUpdateScheduler extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        "command:fetchlastupdate"
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        printf(public_path("/tasks/test.txt"));

        $schedule->call(function() {
            Log::warning("Scheduler called");
        })->everyMinute()->sendOutputTo(public_path("/tasks/test.txt"));
    }
}
