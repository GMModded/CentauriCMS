<?php
namespace Centauri\CMS\Component;

use Centauri\CMS\Centauri;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExtensionsComponent
{
    public function __construct()
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
                        $extClass = Centauri::makeInstance($config["mainclass"]);
                        $GLOBALS["Centauri"]["Extensions"][$extName] = $config;
                    }
                }
            }
        }
    }
}
