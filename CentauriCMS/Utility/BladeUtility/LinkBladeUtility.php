<?php
namespace Centauri\CMS\Utility\BladeUtility;

use Centauri\CMS\Utility\DomainsUtility;

class LinkBladeUtility
{
    public static function getLinkByPage($page)
    {
        $domainFile = DomainsUtility::getDomainFileByHost(request()->getHost());
        $domainConfig = DomainsUtility::getConfigByDomainFile($domainFile);

        $domain = $domainConfig->domain;

        $ssl = "https://";

        if(isset($domainConfig->ssl)) {
            if(!$domainConfig->ssl) {
                $ssl = "http://";
            }
        }

        return $ssl . $domain . $page->slugs;
    }
}
