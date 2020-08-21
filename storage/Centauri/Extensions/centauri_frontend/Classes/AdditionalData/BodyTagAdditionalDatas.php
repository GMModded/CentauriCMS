<?php
namespace Centauri\Extension\Frontend\AdditionalDatas;

class BodyTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<script src='" . 
            \Centauri\CMS\Helper\GulpRevHelper::include(
                "/storage/Centauri/Extensions/centauri_frontend/public",
                "js",
                "centauri.min.js"
            ) . "' async defer></script>"
        ];

        return implode("\r\n", $tags);
    }
}
