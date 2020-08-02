<?php
namespace Centauri\Extension\Frontend\AdditionalDatas;

use Centauri\CMS\Centauri;
use Centauri\CMS\Utility\PathUtility;

class HeadTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<link rel='stylesheet' href='" . \Centauri\CMS\Helper\GulpRevHelper::include(
                PathUtility::getAbsURL("storage/Centauri/Extensions/centauri_frontend/public"),
                "css",
                "centauri.min.css"
            ) . "'>"
        ];

        return implode("\r\n", $tags);
    }
}
