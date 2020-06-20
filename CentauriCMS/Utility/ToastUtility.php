<?php
namespace Centauri\CMS\Utility;

class ToastUtility
{
    public static function show($type, $title, $description = "", $options = [])
    {
        $description = str_replace("\\", "\\\\", $description);

        $options = json_encode($options);
        echo '<script class="toastutil-notification">Centauri.Notify("' . $type . '", "' . $title . '", "' . $description . '", ' . $options . ');$("script.toastutil-notification").remove();</script>';
    }
}
