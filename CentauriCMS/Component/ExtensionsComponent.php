<?php
namespace Centauri\CMS\Component;

use Centauri\CMS\Centauri;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExtensionsComponent
{
    public function loadExtensions()
    {
        $extensionsDirs = Storage::disk("centauri_extensions")->allDirectories();
        $extensionsFiles = Storage::disk("centauri_extensions")->allFiles();

        $extensions = array_merge($extensionsDirs, $extensionsFiles);

        foreach($extensions as $extension) {
            if(!Str::contains($extension, "/")) {
                $extName = $extension;
                $extConfigFilePath = storage_path("Centauri/Extensions/$extName/ext_config.php");

                if(!file_exists($extConfigFilePath)) {
                    throw new Exception("Extension: '$extName' error - the $extConfigFilePath configuration file for the extension itself is missing by CentauriCMS.");
                } else {
                    $config = include $extConfigFilePath;

                    if(gettype($config) == "array") {
                        $loadExtension = true;

                        if(isset($config["status"])) {
                            if($config["status"] != "ENABLED") {
                                $loadExtension = false;
                            }
                        }

                        if($loadExtension) {
                            $mainclass = $config["mainclass"];

                            Centauri::makeInstance($mainclass);
                            $GLOBALS["Centauri"]["Extensions"][$extName] = $config;
                        }
                    }
                }
            }
        }
    }

    public static function getExtensions()
    {
        return $GLOBALS["Centauri"]["Extensions"];
    }
}
