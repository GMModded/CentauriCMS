<?php
namespace Centauri\Extension\Cookie\AdditionalDatas;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ExtensionsComponent;

class BodyTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<script src='" . ExtensionsComponent::extPath("centauri_cookies/public/js/cookiepopup.js") . "'></script>"
        ];

        return implode("\r\n", $tags);
    }
}
