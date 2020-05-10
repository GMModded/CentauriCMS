<?php
namespace Centauri\CMS\Utility;

use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Page;
use Illuminate\Support\Facades\File;

class DomainsUtility
{
    public static function findAll()
    {
        $path = base_path("CentauriCMS/Domains");
        $domainFiles = File::files($path);

        foreach($domainFiles as $domainFile) {
            $content = file_get_contents($domainFile->getPathname());
            $domainFile->content = json_decode($content);

            $rootpageuid = $domainFile->content->rootpageuid;
            $rootpage = Page::where("uid", $rootpageuid)->get()->first();

            if(!is_null($rootpage)) {
                $language = Language::where("uid", $rootpage->lid)->get()->first();
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
}
