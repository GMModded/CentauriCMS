<?php
namespace Centauri\CMS\Caches;

/**
 * This caching class will either cache a specific page (frontend only) if it has not been found as static file
 * or will create a cached file of the outputted/rendered page.
 */
class StaticFileCache
{
    public static $cachedTempDirPath = "";

    /**
     * The constructor for the StaticFileCache class.
     * Sets currently only the cached temporary directory path.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->cachedTempDirPath = realpath(__DIR__ . "\\..\\temp\\Cache");
    }

    /**
     * Sets a static file cache by a given id with optional data (which will be saved into this cache file)
     * (Should) return true if the fopen, fwrite and the fclose functions has been executed without any error by php itself.
     * 
     * @param string $id - The uniqid generated in the context when using hasCache static method
     * @param string $data - The data (string) which should get cached
     * 
     * @return boolean|null|void
     */
    public static function setCache(string $id, string $data): bool
    {
        $cachedFile = fopen(self::$cachedTempDirPath . "\\$id.html", "w+");
        fwrite($cachedFile, $data);
        fclose($cachedFile);

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
            return;
        }

        return file_get_contents(self::$cachedTempDirPath . "\\$id.html");
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
        return file_exists(self::$cachedTempDirPath . "\\$id.html");
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
        return unlink(self::$cachedTempDirPath . "\\$id.html");
    }

    /**
     * Deletes all cached static files.
     * 
     * @return boolean
     */
    public static function deleteAll()
    {
        if(!is_dir(self::$cachedTempDirPath)) {
            return;
        }

        return unlink(self::$cachedTempDirPath . "\\*.html");
    }
}
