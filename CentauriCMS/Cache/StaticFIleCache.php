<?php
namespace Centauri\CMS\Caches;

/**
 * This caching class will either cache a specific page (frontend only) if it has not been found as static file
 * or will create a cached file of the outputted/rendered page.
 */
class StaticFileCache
{
    /**
     * Returns the path (as a string) to the temp cached directory of rendered pages/html.
     * 
     * @return string
     */
    public static function getCachedTempDir()
    {
        return realpath(__DIR__ . "\\..\\temp\\Cache");
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
        $cachedFile = fopen(self::getCachedTempDir() . "\\$id.html", "w+");
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

        return file_get_contents(self::getCachedTempDir() . "\\$id.html");
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
        return file_exists(self::getCachedTempDir() . "\\$id.html");
    }
}
