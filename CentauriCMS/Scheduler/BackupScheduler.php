<?php
namespace Centauri\CMS\Scheduler;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BackupScheduler
{
    public function handle()
    {
        $host = config("app")["db_host"];
        $dbname = config("app")["db_database"];
        $username = config("app")["db_username"];
        $password = config("app")["db_password"];

        $now = now();
        $now = str_replace(" ", "-", $now);
        $now = str_replace(":", "-", $now);

        $path = storage_path("Centauri/Backups");
        if(!Storage::exists($path)) {
            File::makeDirectory($path, 0775, true);
        }

        \Spatie\DbDumper\Databases\MySql::create()
            ->setHost($host)
            ->setDbName($dbname)
            ->setUserName($username)
            ->setPassword($password)
            ->dumpToFile($path . "/" . $dbname . "_" . $now . ".sql")
        ;

        return true;
    }
}
