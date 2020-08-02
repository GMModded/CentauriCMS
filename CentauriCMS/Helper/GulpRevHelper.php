<?php
namespace Centauri\CMS\Helper;

use Centauri\CMS\Centauri;

/**
 * This class is for including asset files such as .css / .js files which are versioned and using the "gulp-rev" npm-module.
 */
class GulpRevHelper
{
    /**
     * This method will return the absolute OR relative URL (if specified) of the requested rev-file.
     * It's only made for relative paths and wouldn't make any sense anyways to load an external .css-/.js-file from another host.
     * 
     * @param string $path The path/directory where to look for the file which is specified by the second parameter.
     * @param string $name The name to find get the versioned URL - the file itself will be searched inside the $path.
     * @param string $manifestFileName The rev-manifest.json file which is generated and defines the versions with an unique identifier - optional.
     * 
     * @return string
     */
    public static function include($path, $subdir, $name, $manifestFileName = "rev-manifest.json")
    {
        $manifestFilePath = $path . "/" . $manifestFileName;

        // if(!file_exists($manifestFilePath)) {
        //     Centauri::throwStaticException("The rev-manifest.json file could not be found - path which has been checked: '" . $manifestFilePath . "'");
        // }

        $content = json_decode(file_get_contents($manifestFilePath));

        if(!isset($content->$name)) {
            Centauri::throwStaticException("The rev-manifest.json doesn't contains the identifier $name");
        }

        return "$path/$subdir/" . $content->$name;
    }
}
