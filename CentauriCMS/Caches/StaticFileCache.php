<?php
namespace Centauri\CMS\Caches;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * This caching class will either cache a specific page (frontend only) if it has not been found as static file
 * or will create a cached file of the outputted/rendered page.
 */
class StaticFileCache
{
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
     * @param string $id - The uniqid generated in the context when using hasCache static method
     * @param string $data - The data (string) which should get cached
     * 
     * @return boolean|null|void
     */
    public static function setCache(string $id, string $data): bool
    {
        if(isset(config("centauri")["config"]["Caching"]["imagesToBase64"]) && (config("centauri")["config"]["Caching"]["imagesToBase64"])) {
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

        Storage::disk("centauri_temp_cache")->put("$id.html", $data);
        return true;
    }

    /**
     * Returns content from a cache by its id
     * 
     * @param string $id - The uniqid of the cache
     * 
     * @return boolean|string
     */
    public static function getCache($id)
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
     * > Example: centauricmsde-1 (for centauricms.de and page uid '1')
     * 
     * @param string $host The hostname of the static file cache.
     * @param string $uid The page uid which has been requested.
     * 
     * @return string
     */
    public static function getUniqIdByHostPageUid($host, $uid = -1)
    {
        if($uid == -1) {
            dd("ksmk not found");
        }

        return preg_replace("/[^a-zA-Z0-9]+/", "", $host) . "-" . $uid;
    }

    public static function hasCacheKernel($requestedUri)
    {
        $pathToCachedFile = dirname(__FILE__) . "/../../storage/Centauri/temp/Cache" . $requestedUri . ".html";

        $exists = file_exists($pathToCachedFile);

        if($exists) {
            return file_get_contents($pathToCachedFile);
        }

        return $exists;
    }

    public static function setCacheKernel($requestedUri, $data)
    {
        if(self::hasCacheKernel($requestedUri) === false) {
            $pathToCachedFile = dirname(__FILE__) . "/../../storage/Centauri/temp/Cache" . $requestedUri . ".html";
            file_put_contents($pathToCachedFile, $data);
        }
    }
}
