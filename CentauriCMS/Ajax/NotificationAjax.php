<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Model\Notification;
use Centauri\CMS\Traits\AjaxTrait;
use Illuminate\Http\Request;

class NotificationAjax
{
    use AjaxTrait;

    /**
     * Deletes a notification-record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deleteByUidAjax(Request $request)
    {
        $uid = $request->input("uid");
        Notification::destroy($uid);

        return json_encode([
            "type" => "primary",
            "title" => "Notifications",
            "description" => "This notification has been deleted"
        ]);
    }
    
    /**
     * Deletes all notification-records.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function deleteAllAjax(Request $request)
    {
        Notification::truncate();

        return json_encode([
            "type" => "primary",
            "title" => "Notifications",
            "description" => "All notifications have been deleted"
        ]);
    }
}
