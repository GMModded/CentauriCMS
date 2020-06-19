<?php
namespace Centauri\Extension\Frontend\Scheduler;

use Centauri\Extension\Frontend\Event\MyEvent;

class PusherScheduler
{
    public function handle()
    {
        event(new MyEvent([
            "reloadpage" => true
        ]));

        return true;
    }
}
