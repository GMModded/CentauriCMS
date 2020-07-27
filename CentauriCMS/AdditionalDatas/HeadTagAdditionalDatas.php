<?php
namespace Centauri\CMS\AdditionalDatas;

class HeadTagAdditionalDatas
{
    public function fetch()
    {
        $csrfToken = csrf_token();

        if(is_null($csrfToken)) {
            return redirect("/");
        }

        $metaTags = [
            "<meta charset='UTF-8' />",
            "<meta name='viewport' content='width=device-width, initial-scale=1.0'>",
            "<meta http-equiv='X-UA-Compatible' content='ie=edge'>",
            "<meta name='csrf-token' content='" . csrf_token() . "'>"
        ];

        return implode("\r\n", $metaTags);
    }
}
