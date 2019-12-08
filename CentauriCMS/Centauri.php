<?php
namespace Centauri\CMS;

class Centauri
{
    /**
     * Centauri Core version
     */
    protected $version = "1.0;EA1";

    /**
     * Makes an instance of the given $class param
     * 
     * @param class $class - Class name as class-object
     * 
     * @return class
     */
    public static function makeInstance($class)
    {
        return new $class;
    }
}
