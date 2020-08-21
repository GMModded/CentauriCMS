<?php
namespace Centauri\CMS\Component;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Centauri\CMS\Centauri;
use Centauri\CMS\Utility\NotificationUtility;

class ExtensionsComponent
{
    public function loadExtensions()
    {
        $extensions = Storage::disk("centauri_extensions")->directories();

        foreach($extensions as $extension) {
            if(!Str::contains($extension, "/")) {
                $extName = $extension;

                $extConfigFilePath = Storage::disk("centauri_extensions")->getAdapter()->getPathPrefix() . "$extName/ext_config.php";

                $exists = Storage::disk("centauri_extensions")->get("$extName/ext_config.php");

                if(!$exists) {
                    throw new Exception("Extension: '$extName' error - path: '$extConfigFilePath' configuration file for the extension itself is missing");
                } else {
                    $config = include $extConfigFilePath;

                    if(gettype($config) == "array") {
                        $loadExtension = true;

                        if(isset($config["status"])) {
                            if($config["status"] != "ENABLED") {
                                $loadExtension = false;
                            }
                        }

                        // if(!isset($GLOBALS["Centauri"]["Extensions"][$extName])) {
                            if($loadExtension) {
                                $mainclass = $config["mainclass"];

                                if(!class_exists($mainclass)) {
                                    if(Centauri::isProduction()) {
                                        $errMsg = "The class $mainclass could not be found while loading all extensions!";
                                        NotificationUtility::create("ERROR", "Centauri Extensions-Component", $errMsg, "error");
                                        continue;
                                    }
                                }

                                Centauri::makeInstance($mainclass)->init();

                                if(!isset($GLOBALS["Centauri"]["Extensions"][$extName])) {
                                    $GLOBALS["Centauri"]["Extensions"][$extName] = $config;
                                }
                            }
                        // }
                    }
                }
            }
        }
    }

    public static function getExtensions()
    {
        return $GLOBALS["Centauri"]["Extensions"];
    }

    public static function extPath($extension)
    {
        return asset("storage/Centauri/Extensions/$extension");
    }
}
