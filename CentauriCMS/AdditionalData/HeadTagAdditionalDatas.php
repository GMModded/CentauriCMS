<?php
namespace Centauri\CMS\AdditionalDatas;

class HeadTagAdditionalDatas implements \Centauri\CMS\AdditionalDataInterface
{
    public function fetch()
    {
        $onload = "this.media='all'";

        $metaTags = [
            "<meta charset='UTF-8' />",
            "<meta name='viewport' content='width=device-width, initial-scale=1.0'>",
            "<meta http-equiv='X-UA-Compatible' content='ie=edge'>",
            "<link rel='stylesheet' href='" . asset("public/frontend/css/centauri.min.css") . "' media='print' onload=" . $onload . ">"
        ];

        return implode("\r\n", $metaTags);
    }

    public function onEditListener($element)
    {
        //
    }
}
