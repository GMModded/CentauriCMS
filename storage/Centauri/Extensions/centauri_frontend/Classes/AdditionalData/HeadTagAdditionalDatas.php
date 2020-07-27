<?php
namespace Centauri\Extension\Frontend\AdditionalDatas;

use Centauri\CMS\Component\ExtensionsComponent;

class HeadTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<link rel='stylesheet' href='" . ExtensionsComponent::extPath("centauri_frontend/public/css/centauri.min.css") . "'>"
        ];

        return implode("\r\n", $tags);
    }
}
