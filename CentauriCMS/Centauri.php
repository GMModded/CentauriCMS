<?php
namespace Centauri\CMS;

use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Model\Scheduler;
use Centauri\CMS\Service\ModulesService;
use Centauri\CMS\Service\PathService;
use Centauri\CMS\Service\SchedulerService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class Centauri extends ServiceProvider
{
    /**
     * Centauri Core version
     * 
     * @var string $version
     */
    protected $version = "1.0;EA1";

    /**
     * Tables for initDB-method
     * 
     * @var $tables array
     */
    protected $tables = [
        "be_users",
        // "elements",
        // "languages",
        // "notifications",
        // "pages"
    ];

    /**
     * CentauriCMS root directory
     * 
     * @var static $centauriDir string
     */
    protected static $centauriDir = __DIR__;

    /**
     * Centauri Modules-Service
     * 
     * @var private $modulesService class
     */
    private $modulesService;

    /**
     * Centauri Path-Service
     * 
     * @var private $pathService class
     */
    private $pathService;

    /**
     * Centauri Core Constructor
     */
    public function __construct()
    {
        $this->initDB();

        View::addNamespace("Centauri", base_path("CentauriCMS/Views"));

        $this->extensionsComponent = Centauri::makeInstance(ExtensionsComponent::class);
        $this->modulesService = Centauri::makeInstance(ModulesService::class);
        $this->pathService = Centauri::makeInstance(PathService::class);
        $this->schedulerService = Centauri::makeInstance(SchedulerService::class);

        $this->initBE();
    }


    /**
     * Makes an instance of the given $class param
     * 
     * @param class $class - Class name as class-object
     * 
     * @return class
     */
    public static function makeInstance($class, $params = [])
    {
        return new $class($params);
    }

    /**
     * Initialization of the backend when an user logged into it
     */
    public function initBE()
    {
        \Illuminate\Support\Facades\App::setLocale(request()->session()->get("CENTAURI_LANGUAGE"));

        $this->extensionsComponent;

        $this->modulesService->init();
        $this->pathService->init();
    }

    /**
     * Initialization of the tables which are required in order to run Centauri properly.
     */
    public function initDB()
    {
        foreach($this->tables as $table) {
            if(!Schema::hasTable($table)) {
                // throw new Exception("Table: $table doesn't exists - please run a refresh of the migration for this table with Laravel Artisan or use Centauri FixUtility-Class.");
            }
        }
    }

    public static function isProduction()
    {
        $env = strtolower(app("env"));

        if(
            $env == "production" ||
            $env == "prod"
        ) {
            return true;
        }

        return false;
    }

    public static function isLocal()
    {
        $env = strtolower(app("env"));

        if(
            $env == "local" ||
            $env == "staging"
        ) {
            return true;
        }

        return false;
    }
}
