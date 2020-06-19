<?php
namespace Centauri\Extension\Jobs\Modules;

class JobsModule
{
    public function __construct()
    {
        $GLOBALS["Centauri"]["Modules"]["centauri_jobs_mod1"] = [
            "title" => "Jobs",
            "icon" => "<i class='fas fa-list'></i>",
            "DataFetcher" => \Centauri\Extension\Fetcher\JobsModuleFetcher::class
        ];
    }
}
