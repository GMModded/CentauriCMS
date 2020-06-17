<?php
namespace Centauri\CMS\Service;

class SchedulerService
{
    public static function run($schedulerID)
    {
        // $schedulers = $GLOBALS["Centauri"]["Schedulers"];
        // $schedulerRunning = $schedulers[$schedulerID] ?? false;

        // dump($GLOBALS["Centauri"]["Schedulers"]);

        // if(!$schedulerRunning) {
        //     $GLOBALS["Centauri"]["Schedulers"][$schedulerID] = true;
        //     dump($GLOBALS["Centauri"]["Schedulers"]);

        //     $path = __DIR__ . "/../../" . $schedulerID . ".php";
        //     dump($path);

        //     $a = shell_exec("/usr/bin/php $path 2>&1");
        //     echo "<pre>" . $a . "</pre>";

        //     $GLOBALS["Centauri"]["Schedulers"][$schedulerID] = false;
        // } else {
        //     echo "Scheduler is running.";
        // }
        // dump($GLOBALS["Centauri"]["Schedulers"]);

        // return;
    }
}
