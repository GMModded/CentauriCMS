<?php
namespace Centauri\CMS\AdditionalDatas;

class HeadTagAdditionalDatas implements \Centauri\CMS\AdditionalDataInterface
{
    public function fetch()
    {
        $metaTags = [
            "<meta charset='UTF-8' />",
            "<meta name='description' content='Centauri is a CMS based on Laravel 6 (a PHP Framework). This is the official website.' />",
            "<meta name='keywords' content='Centauri, CMS, Content Management System, professional, modern'>",
            "<meta name='viewport' content='width=device-width, initial-scale=1.0'>",
            "<meta http-equiv='X-UA-Compatible' content='ie=edge'>"
        ];

        return implode("\r\n", $metaTags);
    }

    public function onEditListener($element)
    {
        //
    }
}
