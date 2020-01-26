<?php
namespace Centauri\CMS\Utility;

class PathUtility
{
    public function getBaseURL()
    {
        $baseURL = env("APP_URL");

        if(mb_substr($baseURL, -1) != "/") {
            $baseURL .= "/";
        }

        return $baseURL;
    }

    public function getBackendURL()
    {
        return $this->getBaseURL() . "centauri/";
    }
}
