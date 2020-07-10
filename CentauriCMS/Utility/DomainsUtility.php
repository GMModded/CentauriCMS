<?php
namespace Centauri\CMS\Utility;

use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Page;
use Illuminate\Support\Facades\File;

class DomainsUtility
{
    public static function findAll()
    {
        $path = storage_path("Centauri/Domains");
        $domainFiles = File::files($path);

        foreach($domainFiles as $domainFile) {
            $content = file_get_contents($domainFile->getPathname());
            $domainFile->content = json_decode($content);

            $rootpageuid = $domainFile->content->rootpageuid ?? null;

            if(is_null($rootpageuid)) {
                throw new \Exception("Rootpageuid inside Domain-Config: '" . $domainFile . "' couldn't be determined");
            }

            $rootpage = Page::where("uid", $rootpageuid)->get()->first();

            if(!is_null($rootpage)) {
                $language = Language::where("uid", $rootpage->lid)->get()->first();

                if(is_null($language)) {
                    throw new \Exception(
                        "Language ID (#"
                    .
                        $rootpage->lid
                    .
                        ") for Rootpage '"
                    .
                        $rootpage->title
                    .
                        "' (UID: #"
                    .
                        $rootpage->uid
                    .
                        ") doesn't exists"
                    );
                }

                $rootpage->language = $language;
                $domainFile->content->rootpage = $rootpage;
            }
        }

        return $domainFiles;
    }

    public static function getDomainFileByHost($host)
    {
        $domainFiles = self::findAll();
        $domain = null;

        foreach($domainFiles as $domainFile) {
            $domainValue = $domainFile->content->domain;

            if(is_null($domain)) {
                if($host == $domainValue) {
                    $domain = $domainFile;
                } else if($host == $domainValue) {
                    $domain = $domainFile;
                }
            }
        }

        return $domain;
    }

    public static function getConfigByDomainFile($domainFile, $json = false)
    {
        return json_decode(file_get_contents($domainFile), $json);
    }

    public static function findDomainConfigByPageUid($uid)
    {
        $domainFiles = self::findAll();
        $nConfig = null;

        foreach($domainFiles as $domainFile) {
            $config = self::getConfigByDomainFile($domainFile);

            if($config->rootpageuid == $uid) {
                $nConfig = $config;
            }
        }

        return $nConfig;
    }

    public static function getUriByConfig($config)
    {
        if(is_null($config)) {
            return;
        }

        $protocol = "http://";
        $uri = $config->domain;

        if(isset($config->ssl)) {
            if($config->ssl) {
                $protocol = "https://";
            }
        }

        $uri = $protocol . $uri;
        return $uri;
    }
}
