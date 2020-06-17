<?php

namespace App\Console;

use Centauri\CMS\Model\Scheduler;
use Centauri\CMS\Service\ExecuteSchedulerService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedulers = Scheduler::get()->all();

        foreach($schedulers as $scheduler) {
            $uid = $scheduler->uid;

            $time = $scheduler->time;

            $schedule
                ->call(function() use($uid) {
                    /**
                     * Returns JSON string back.
                     */
                    $data = ExecuteSchedulerService::execute($uid);
                })
            ->runInBackground()
            ->$time();
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }
}
