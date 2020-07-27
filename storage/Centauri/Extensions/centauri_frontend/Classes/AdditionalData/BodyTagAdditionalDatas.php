<?php
namespace Centauri\Extension\Frontend\AdditionalDatas;

use Centauri\CMS\Component\ExtensionsComponent;

class BodyTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<script src='" . ExtensionsComponent::extPath("centauri_frontend/public/js/centauri.min.js") . "' async></script>"
        ];

        return implode("\r\n", $tags);
    }
}
