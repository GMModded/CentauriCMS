<?php
namespace Centauri\CMS;

use Centauri\CMS\Bootstrapping\CentauriBootstrapping;
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
    protected static $version = "1.0";

    /**
     * Centauri Core state-version
     * 
     * @var string $state
     */
    protected static $state = "Early-Access";

    /**
     * Context of the application.
     * 
     * @var string $applicationContext
     */
    protected static $applicationContext = "";

    /**
     * Tables for initDB-method
     * 
     * @var array $tables
     */
    protected $tables = [
        // "be_users",
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
     * @var class $modulesService class
     */
    private $modulesService;

    /**
     * Centauri Path-Service
     * 
     * @var class $pathService class
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
     * 
     * @return void
     */
    public function initBE()
    {
        \Illuminate\Support\Facades\App::setLocale(request()->session()->get("CENTAURI_LANGUAGE"));

        $this->extensionsComponent->loadExtensions();

        $this->modulesService->init();
        $this->pathService->init();

        Centauri::makeInstance(CentauriBootstrapping::class);
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

    /**
     * Determines if the application is running on production (e.g. live) mode
     * And returns possibly true, else false.
     * 
     * @return boolean
     */
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

    /**
     * Determines if the application is running in local (e.g. docker/development) mode
     * And returns possibly true, else false.
     * 
     * @return boolean
     */
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

    /**
     * Current version of Centauri.
     * 
     * @return string
     */
    public static function getVersion()
    {
        return self::$version;
    }

    /**
     * Current version of Centauri's state.
     * 
     * @return string
     */
    public static function getState()
    {
        return self::$state;
    }

    /**
     * Sets the context of the application.
     * 
     * @param string $applicationContext
     * 
     * @return void
     */
    public static function setApplicationContext($applicationContext)
    {
        self::$applicationContext = $applicationContext;
    }

    /**
     * The context of the application.
     * 
     * @return string
     */
    public static function getApplicationContext()
    {
        return self::$applicationContext;
    }

    /**
     * Returns if sites, in case throwing an exception, should be tried to get annulated or redirect to the home page.
     * 
     * @return void
     */
    public static function keepSiteAlive()
    {
        $keepSiteAlive = config("centauri")["config"]["FE"]["keepSiteAlive"] ?? null;

        if(!is_null($keepSiteAlive)) {
            return $keepSiteAlive;
        }

        return false;
    }
}
