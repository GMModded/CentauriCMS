<?php
namespace Centauri\Extension\Cookie\AdditionalDatas;

use Centauri\CMS\Utility\PathUtility;

class BodyTagAdditionalDatas
{
    public function fetch()
    {
        $tags = [
            "<script src='" . PathUtility::getAbsURL("storage/Centauri/Extensions/centauri_cookies/public/js/cookiepopup.js") . "'></script>"
        ];

        return implode("\r\n", $tags);
    }
}
