<?php
namespace Centauri\CMS\AdditionalDatas;

class HeadTagAdditionalDatas
{
    public function fetch()
    {
        $kernelLevelCachingStatus = config("centauri-server")["KERNEL_LEVEL_CACHING"]["status"];
        $csrfToken = null;

        if(!$kernelLevelCachingStatus) {
            $csrfToken = csrf_token();

            if(is_null($csrfToken)) {
                return redirect("/");
            }
        }

        $metaTags = [
            "charset" => "<meta charset='UTF-8' />",
            "viewport" => "<meta name='viewport' content='width=device-width, initial-scale=1.0'>",
            "http-equiv" => "<meta http-equiv='X-UA-Compatible' content='ie=edge'>",
            "csrf-token" => "<meta name='csrf-token' content='" . $csrfToken . "'>",

            "stylesheet-centauri-env" => "<link rel='stylesheet' href='/resources/css/centauri-env.css'>"
        ];

        if($kernelLevelCachingStatus) {
            unset($metaTags["csrf-token"]);
        }

        return implode("\r\n", $metaTags);
    }
}
