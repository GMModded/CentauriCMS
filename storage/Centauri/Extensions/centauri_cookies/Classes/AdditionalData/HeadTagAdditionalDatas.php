<?php
namespace Centauri\Extension\Cookie\AdditionalDatas;

use Centauri\CMS\Component\ExtensionsComponent;

class HeadTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<link rel='stylesheet' href='" . ExtensionsComponent::extPath("centauri_cookies/public/css/cookiepopup.css") . "'>"
        ];

        return implode("\r\n", $tags);
    }
}
