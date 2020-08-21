<?php
namespace Centauri\CMS\Controller;

class CentauriController
{
    /**
     * Returns classname for URIBladeHelper (linkAction method) when generating action-URL
     * 
     * @return string
     */
    public function getShortName()
    {
        $path = explode("\\", static::class);
        return array_pop($path);
    }
}
