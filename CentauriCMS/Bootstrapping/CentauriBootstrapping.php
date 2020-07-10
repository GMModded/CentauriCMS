<?php
namespace Centauri\CMS\Bootstrapping;

use Centauri\CMS\Centauri;
use Illuminate\Database\Connection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CentauriBootstrapping
{
    /**
     * Constructor when Centauri is in Bootstrapping-phase.
     * 
     * @return void
     */
    public function __construct()
    {
        $env = app("env");
        Centauri::setApplicationContext($env);
    }
}
