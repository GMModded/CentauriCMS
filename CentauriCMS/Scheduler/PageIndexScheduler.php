<?php
namespace Centauri\CMS\Scheduler;

use Illuminate\Support\Facades\Log;

class PageIndexScheduler
{
    public function handle()
    {
        Log::info("PageIndexScheduler called.");
    }
}
