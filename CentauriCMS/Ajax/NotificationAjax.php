<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Model\Notification;
use Illuminate\Http\Request;

class NotificationAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        $uid = $request->input("uid");
        Notification::destroy($uid);

        return json_encode([
            "type" => "primary",
            "title" => "Notifications",
            "description" => "This notification has been deleted"
        ]);

        // return AjaxAbstract::default($request, $ajaxName);
    }
}
