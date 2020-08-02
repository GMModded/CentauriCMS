<?php
namespace Centauri\Extension\Frontend\AdditionalDatas;

use Centauri\CMS\Utility\PathUtility;

class BodyTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<script src='" . \Centauri\CMS\Helper\GulpRevHelper::include(
                PathUtility::getAbsURL("storage/Centauri/Extensions/centauri_frontend/public"),
                "js",
                "centauri.min.js"
            ) . "' async defer></script>"
        ];

        return implode("\r\n", $tags);
    }
}
