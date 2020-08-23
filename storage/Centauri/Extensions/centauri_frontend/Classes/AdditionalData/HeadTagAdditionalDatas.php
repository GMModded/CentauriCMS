<?php
namespace Centauri\Extension\Frontend\AdditionalDatas;

class HeadTagAdditionalDatas
{
    public function fetch()
    {
        // dd(\Centauri\CMS\Helper\GulpRevHelper::include(
        //     "/storage/Centauri/Extensions/centauri_frontend/public",
        //     "css",
        //     "centauri.min.css"
        // ));

        $tags = [
            "<link rel='stylesheet' href='" . \Centauri\CMS\Helper\GulpRevHelper::include(
                "/storage/Centauri/Extensions/centauri_frontend/public",
                "css",
                "centauri.min.css"
            ) . "'>"
        ];

        return implode("\r\n", $tags);
    }
}
