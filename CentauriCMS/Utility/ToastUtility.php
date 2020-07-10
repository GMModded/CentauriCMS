<?php
namespace Centauri\CMS\Utility;

class ToastUtility
{
    /**
     * Toast / Notification Utility
     * 
     * @param string $type The severity of this toast.
     * @param string $title The title (heading) of the notification.
     * @param string $description Optimal a description of "what happened".
     * @param array $options Additional options.
     * 
     * @return void
     */
    public static function show($type, $title, $description = "", $options = [])
    {
        $description = str_replace("\\", "\\\\", $description);

        $options = json_encode($options);
        echo '<script class="toastutil-notification">Centauri.Notify("' . $type . '", "' . $title . '", "' . $description . '", ' . $options . ');$("script.toastutil-notification").remove();</script>';
    }
}
