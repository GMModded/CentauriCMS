<?php
namespace Centauri\CMS\CentauriServer;

use Centauri\CMS\Centauri;
use Centauri\CMS\CentauriServer;
use Exception;

class ExtensionsLoader extends CentauriServer
{
    /**
     * Calling the parent in case config-property is set before actually using it in this class itself.
     * 
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function load()
    {
        $paths = $this->getConfig("PATHS");
        $extPath = $paths->centauri_storage_extensions;

        $extensions = array_diff(
            scandir($extPath),

            [
                ".",
                ".."
            ]
        );

        foreach($extensions as $extension) {
            $extName = $extension;

            $extensionPath = $extPath . $extName . "/";
            $extConfigFilePath = $extensionPath . "ext_config.php";

            $exists = file_exists($extConfigFilePath);

            if(!$exists) {
                throw new Exception("Extension: '$extName' error - path: '$extConfigFilePath' configuration file for the extension itself is missing");
            }

            $config = include $extConfigFilePath;

            if(gettype($config) == "array") {
                $loadExtension = true;

                if(isset($config["status"])) {
                    if($config["status"] != "ENABLED") {
                        $loadExtension = false;
                    }
                }

                if(!isset($GLOBALS["Centauri"]["Extensions"][$extName]) && $loadExtension) {
                    $mainclass = $config["mainclass"];

                    if(!class_exists($mainclass)) {
                        throw new Exception("Extension: '$extName' error - the Main-Class: '$mainclass' for the extension itself could not be found (maybe not loaded yet?)");
                    }

                    $classConfig = Centauri::makeInstance($mainclass)->kernelRegistrationLoader();

                    $GLOBALS["Centauri"]["Extensions"][$extName] = (is_null($classConfig) ? $config : $classConfig);
                }
            }
        }
    }
}
