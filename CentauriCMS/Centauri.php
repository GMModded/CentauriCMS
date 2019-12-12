<?php
namespace Centauri\CMS;

use Centauri\CMS\Service\ModulesService;

class Centauri
{
    /**
     * Centauri Core version
     */
    protected $version = "1.0;EA1";

    /**
     * CentauriCMS root directory
     */
    protected static $centauriDir = __DIR__;

    /**
     * Centauri Services
     */
    private $modulesService;

    /**
     * Centauri Core
     */
    public function __construct()
    {
        $this->modulesService = Centauri::makeInstance(ModulesService::class);
    }


    /**
     * Makes an instance of the given $class param
     * 
     * @param class $class - Class name as class-object
     * @return class
     */
    public static function makeInstance($class)
    {
        return new $class;
    }

    /**
     * Initialization of the backend when an user logged into it
     */
    public function initBE()
    {
        $GLOBALS["Centauri"]["Core"]["BE"]["LID"] = 0;

        $this->modulesService->init();

        // GlobalsCentauriCore
        $GCC = $GLOBALS["Centauri"]["Core"];

        return [
            "modules" => $GCC["Modules"]
        ];
    }
}
