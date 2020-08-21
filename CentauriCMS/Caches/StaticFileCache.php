<?php
namespace Centauri\CMS\Caches;

use Centauri\CMS\Centauri;
use Centauri\CMS\Utility\SeoUrlUtility;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * This caching class will either cache a specific page (frontend only) if it has not been found as static file
 * or will create a cached file of the outputted/rendered page.
 */
class StaticFileCache
{
    /**
     * Path to the cached temp directory inside storage folder.
     * 
     * @var string
     */
    public static $cachedTempDirPath = null;

    /**
     * The constructor for the StaticFileCache class.
     * Sets currently only the cached temporary directory path.
     * 
     * @return void
     */
    public function __construct()
    {
        self::$cachedTempDirPath = self::getCachedTempDirPath();
    }

    /**
     * This method will set the cached temporary directory path.
     * 
     * @return string
     */
    public static function getCachedTempDirPath()
    {
        return base_path("../storage/Centauri/temp/Cache");
    }

    /**
     * Sets a static file cache by the given $id with given $data (which will be saved into this cache file).
     * Optional if the centauri-config file has enabled imagesToBase64 it will convert images to base64 format.
     * 
     * @param string $id The uniqid generated in the context when using hasCache static method
     * @param string $data The data (string) which should get cached
     * @param bool $storeCachedFile (Optional) Determines whether the $data-string should be stored as a $id.html-file in
     * "centauri_temp_cache"-disk. If set to false it'll returns the actually stored data back.
     * @param array $options (Optional) An array of options e.g. imagesToBase64 format - these will force, ignoring the config()-helper's value.
     * 
     * @return string|void
     */
    public static function setCache(string $id, string $data, bool $storeCachedFile = true, array $options = [])
    {
        if(
            isset(config("centauri")["config"]["Caching"]["imagesToBase64"]) && (config("centauri")["config"]["Caching"]["imagesToBase64"]) ||
            isset($options["imagesToBase64"]) && ($options["imagesToBase64"])
        ) {
            $explDataLines = explode("\n", $data);

            foreach($explDataLines as $key => $line) {
                $explLine = explode(" ", $line);

                if(Str::contains($line, "image-view placeholder")) {
                    $explDataLines[$key] = str_replace("image-view placeholder", "image-view", $explDataLines[$key]);
                }

                if(Str::contains($line, "<img") && Str::contains($line, "data-src")) {
                    foreach($explLine as $subKey => $exLine) {
                        $_exLine = $exLine;

                        if(Str::contains($exLine, "data-src")) {
                            $exLine = str_replace("data-src=", "", $exLine);
                            $exLine = str_replace('"', "", $exLine);
                            $exLine = str_replace("/storage/Centauri/Filelist/", "", $exLine);

                            $content = Storage::disk("centauri_filelist")->get($exLine);
                            $content = "data:image/png;base64," . base64_encode($content);

                            $_exLine = "src='" . $content . "'";
                            $explLine[$subKey] = $_exLine;
                        }
                    }

                    $explDataLines[$key] = implode(" ", $explLine);
                }
            }

            $data = implode(" ", $explDataLines);

            $data = str_replace("> <", "><", $data);
            $data = str_replace(">  <", "><", $data);
        }

        if($storeCachedFile) {
            $data = implode("", explode("\n", $data));
            Storage::disk("centauri_temp_cache")->put("$id.html", $data);
        } else {
            return $data;
        }
    }

    /**
     * Returns content from a cache by its id
     * 
     * @param string $id - The uniqid of the cache
     * 
     * @return boolean|string
     */
    public static function getCache(string $id)
    {
        if(!self::hasCache($id)) {
            return false;
        }

        $contents = Storage::disk("centauri_temp_cache")->get("$id.html");

        return $contents;
    }

    /**
     * Returns a boolean whether a cache for the given uniq $id exists or not
     * 
     * @param string $id - The uniqid of any cache
     * 
     * @return boolean
     */
    public static function hasCache($id)
    {
        self::$cachedTempDirPath = self::getCachedTempDirPath();

        $exists = Storage::disk("centauri_temp_cache")->exists("$id.html");

        return $exists;
    }

    /**
     * Delets a cached static file by its id.
     * 
     * @param string $id - The uniqid of this cache to be deleted.
     * 
     * @return boolean
     */
    public static function deleteCache($id)
    {
        Storage::disk("centauri_temp_cache")->delete("$id.html");

        return true;
    }

    /**
     * Deletes all cached static files.
     * 
     * @return boolean
     */
    public static function deleteAll()
    {
        $cachedFiles = Storage::disk("centauri_temp_cache")->files("./");
        Storage::disk("centauri_temp_cache")->delete($cachedFiles);

        return true;
    }

    /**
     * Returns the unique identifier (uniqid) of a static file cache by its host and its page-uid.
     * > Example: devcentauricms-1 (for dev.centauricms and page uid '-1')
     * 
     * @param string $host The hostname of the static file cache.
     * @param string $uid The page uid which has been requested.
     * 
     * @return string
     */
    public static function getUniqIdByHostPageUid($host, $uid = null)
    {
        if(is_null($uid)) {
            return;
        }

        return preg_replace("/[^a-zA-Z0-9]+/", "", $host) . "-" . $uid;
    }

    public static function getCacheKernel($requestedUri)
    {
        if($requestedUri == "/") {
            $requestedUri = "/" . SeoUrlUtility::slugify($_SERVER["HTTP_HOST"], "");
        }

        if($requestedUri[0] != "/") {
            $requestedUri = "/" . $requestedUri;
        }

        if(self::hasCacheKernel($requestedUri)) {
            $pathToCachedFile = dirname(__FILE__) . "/../../storage/Centauri/temp/Cache" . $requestedUri . ".html";

            return file_get_contents($pathToCachedFile);
        }

        return false;
    }

    /**
     * This method is used ONLY at Kernel level (/public/index.php) and also ONLY if it's configured to be enabled.
     * 
     * This method checks - independing of Laravel's Storage Facade - whether a cache exists
     * by checking whether the .html-file itself exists in the "/storage/Centauri/temp/Cache/"-directory.
     * 
     * @param string $requestedUri The requested uri which will be converted using the SeoUrlUtility class.
     * 
     * @return boolean
     */
    public static function hasCacheKernel($requestedUri)
    {
        if($requestedUri == "/") {
            $requestedUri = "/" . SeoUrlUtility::slugify($_SERVER["HTTP_HOST"], "");
        }

        if($requestedUri[0] != "/") {
            $requestedUri = "/" . $requestedUri;
        }

        $pathToCachedFile = dirname(__FILE__) . "/../../storage/Centauri/temp/Cache" . $requestedUri . ".html";

        $exists = file_exists($pathToCachedFile);

        return $exists;
    }

    /**
     * This method is used ONLY at Kernel level (/public/index.php) and also ONLY if it's configured to be enabled.
     * 
     * This method caches - if the given $requestedUri isn't cached yet - the current Uri by $data.
     * 
     * @param string $requestedUri The requested uri which will be converted using the SeoUrlUtility class.
     * @param string $data The html-code data which will be stored inside the cached .html-file.
     * 
     * @return void
     */
    public static function setCacheKernel(string $requestedUri, string $data)
    {
        if(
            Str::contains($data, "Ignition\Exceptions") ||
            Str::contains($data, "ErrorException") ||
            (
                Str::contains($data, '<html class="theme-light">') &&
                Str::contains($data, "Error: ")
            )
        ) {
            return;
        }

        if($requestedUri == "/") {
            $requestedUri = SeoUrlUtility::slugify($_SERVER["HTTP_HOST"], "");
        } else {
            if($requestedUri[0] == "/") {
                $requestedUri = preg_replace("/^\//", "", $requestedUri);
            }

            $requestedUri = SeoUrlUtility::slugify($requestedUri, "-");
        }

        $hooks = Centauri::getHookByKey("Cache")["KernelStaticFileCache"]["setCache"];
        $hookData = [];

        foreach($hooks ?? [] as $hook) {
            $hookData = Centauri::makeInstance($hook, [
                "cachedFilename" => $requestedUri,
                "data" => $data
            ])->__construct([
                "cachedFilename" => $requestedUri,
                "data" => $data
            ]);
        }

        if(!empty($hookData)) {
            if(isset($hookData["cachedFilename"])) {
                $requestedUri = "/" . $hookData["cachedFilename"];
            }
        }

        if(!self::hasCacheKernel($requestedUri)) {
            $pathToCachedFile = dirname(__FILE__) . "/../../storage/Centauri/temp/Cache" . $requestedUri . ".html";

            if(!empty($hookData)) {
                $data = $hookData["data"];

                if(isset($hookData["cachedFilename"])) {
                    $cachedFilename = $hookData["cachedFilename"];

                    if($cachedFilename[0] != "/") {
                        $cachedFilename = "/" . $cachedFilename;
                    }

                    $pathToCachedFile = dirname(__FILE__) . "/../../storage/Centauri/temp/Cache" . $cachedFilename . ".html";
                }

                if(is_array($data)) {
                    $data = implode("", $data);
                }
            }

            $data = self::setCache($requestedUri, $data, false);

            file_put_contents($pathToCachedFile, $data);
        }
    }
}
