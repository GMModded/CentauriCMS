<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Notification;
use Centauri\CMS\Model\Scheduler;
use Illuminate\Support\Facades\Log;

class ExecuteSchedulerService
{
    /**
     * Executes a scheduler by its uid.
     * 
     * @param string|int $uid
     * 
     * @return void
     */
    public static function execute($uid, $params = []) {
        $scheduler = Scheduler::where("uid", $uid)->get()->first();

        $scheduler->last_runned = now()->format("d.m.Y - H:i:s");
        $scheduler->state = "Running...";
        $scheduler->save();

        $schedulerInstance = Centauri::makeInstance($scheduler->namespace);
        $data = $schedulerInstance->handle($params);

        if($data) {
            $scheduler->state = "OK";
            $scheduler->save();

            return json_encode([
                "type" => "primary",
                "title" => $scheduler->name . "-Scheduler executed",
                "description" => "The scheduler has been called",
                "scheduler" => $scheduler
            ]);
        }

        /**
         * In case $data does not return true we throw an error and also log for developers.
         */
        $scheduler->state = "FAILED";
        $scheduler->save();

        Log::error("The scheduler with the UID '" . $uid . "' failed!\n");

        $notification = new Notification;
        $notification->severity = "ERROR";
        $notification->title = "Scheduler (UID: '" . $uid . "') failed";
        $notification->text = "Please contact your administrator to inspect the issue here.";
        $notification->save();

        return json_encode([
            "type" => "error",
            "title" => $scheduler->name . "-Scheduler failed",
            "description" => "An error occurred while executing this scheduler",
            "scheduler" => $scheduler
        ]);

        // return response("An error occurred while executing the '" . $scheduler->name . "'-Scheduler!", 500);
    }
}
