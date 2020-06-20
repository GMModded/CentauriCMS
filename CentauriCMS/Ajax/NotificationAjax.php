<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Abstracts\AjaxAbstract;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\Notification;
use Illuminate\Http\Request;

class NotificationAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "deleteByUid") {
            $uid = $request->input("uid");
            Notification::destroy($uid);

            return json_encode([
                "type" => "primary",
                "title" => "Notifications",
                "description" => "This notification has been deleted"
            ]);
        }

        if($ajaxName == "deleteAll") {
            Notification::truncate();

            return json_encode([
                "type" => "primary",
                "title" => "Notifications",
                "description" => "All notifications have been deleted"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
