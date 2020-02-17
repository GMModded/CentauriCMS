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

        if(isset($domain->ssl)) {
            if(!$domain->ssl) {
                $ssl = "http://";
            }
        } else {
            $ssl = "http://";
        }

        return $ssl . $domain . $page->slugs;
    }
}
