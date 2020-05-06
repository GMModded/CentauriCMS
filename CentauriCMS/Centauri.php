<?php
namespace Centauri\CMS;

use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Service\ModulesService;
use Centauri\CMS\Service\PathService;
use Exception;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class Centauri extends ServiceProvider
{
    /**
     * Centauri Core version
     */
    protected $version = "1.0;EA1";

    protected $tables = [
        "be_users",
        // "elements",
        // "languages",
        // "notifications",
        // "pages"
    ];

    /**
     * CentauriCMS root directory
     */
    protected static $centauriDir = __DIR__;

    /**
     * Centauri Modules-Service
     */
    private $modulesService;

    /**
     * Centauri Path-Service
     */
    private $pathService;

    /**
     * Centauri Core
     */
    public function __construct()
    {
        $this->initDB();

        View::addNamespace("Centauri", base_path("CentauriCMS/Views"));

        $this->extensionsComponent = Centauri::makeInstance(ExtensionsComponent::class);
        $this->modulesService = Centauri::makeInstance(ModulesService::class);
        $this->pathService = Centauri::makeInstance(PathService::class);

        $this->initBE();
    }


    /**
     * Makes an instance of the given $class param
     * 
     * @param class $class - Class name as class-object
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
        // dd($this->tables);

        foreach($this->tables as $table) {
            if(!Schema::hasTable($table)) {
                throw new Exception("Table: $table doesn't exists - please run a refresh of the migration for this table with Laravel Artisan or use Centauri FixUtility-Class.");
            }
        }
    }
}
