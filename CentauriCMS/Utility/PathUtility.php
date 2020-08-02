<?php
namespace Centauri\CMS\Utility;

class PathUtility
{
    public function getBaseURL($needles = "")
    {
        $baseURL = env("APP_URL");

        if(mb_substr($baseURL, -1) != "/") {
            $baseURL .= "/";
        }

        if($needles != "") {
            $baseURL .= $needles;
        }

        return $baseURL;
    }

    public function getBackendURL()
    {
        return $this->getBaseURL() . "centauri/";
    }

    public static function getAbsURL($path = "")
    {
        if(mb_substr($path, 0) == "/") {
            $path[0] = "";
        }

        return config("app")["url"] . ($path != "" ? "/" . $path : "");
    }
}
