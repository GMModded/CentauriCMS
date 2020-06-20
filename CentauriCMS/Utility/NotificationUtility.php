<?php
namespace Centauri\CMS\Utility;

use Centauri\CMS\Model\Notification;
use Illuminate\Support\Facades\Log;

class NotificationUtility
{
    /**
     * Efficienter method of creating a notification for the Backend.
     * 
     * @param string $severity Determines the "priority-level" of a notification.
     *                         Possible values are:
     *                            - WARN
     *                            - ERROR
     * 
     * @param string $title Title of the notification
     * @param string $text Text of the notification
     * @param bool $log If not null look into class \Illuminate\Support\Facades for list of available static Log methods.
     * 
     * @return bool
     */
    public static function create($severity, $title, $text, $log = null)
    {
        $lastNotification = Notification::get()->last();
        $lastTimestamp = null;

        if(!is_null($lastNotification)) {
            $lastTimestamp = $lastNotification->created_at->timestamp;
        }

        $notification = new Notification;

        $notification->severity = $severity;
        $notification->title = $title;
        $notification->text = $text;

        if(!is_null($log)) {
            Log::$log("CentauriCMS > " . $text);
        }

        $notification->save();

        if(!is_null($lastTimestamp)) {
            if($lastTimestamp == $notification->created_at->timestamp) {
                $notification->delete();
            }
        }
    }
}
