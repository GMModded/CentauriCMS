<?php
namespace Centauri\CMS\Bootstrapping;

use Centauri\CMS\Centauri;

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
