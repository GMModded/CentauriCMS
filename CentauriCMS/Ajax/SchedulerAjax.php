<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\Scheduler;
use Centauri\CMS\Service\ExecuteSchedulerService;
use Illuminate\Http\Request;

class SchedulerAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        $data = request()->input();

        if($ajaxName == "execute") {
            $config = $data;
            $uid = $config["uid"];

            $params = $config;
            unset($params["uid"]);

            return ExecuteSchedulerService::execute($uid, $params);
        }

        if($ajaxName == "findByUid") {
            $uid = $data["uid"];
            $scheduler = Scheduler::where("uid", $uid)->get()->first();

            return $scheduler;
        }

        if($ajaxName == "saveByUid") {
            $uid = $data["uid"];
            $formData = json_decode($data["formData"]);

            $scheduler = Scheduler::where("uid", $uid)->get()->first();

            foreach($formData as $key => $value) {
                if(!is_null($scheduler->$key)) {
                    $scheduler->$key = $value;
                }
            }

            $scheduler->save();

            return json_encode([
                "type" => "success",
                "title" => $scheduler->name . "-Scheduler",
                "description" => "This scheduler has been successfully saved"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
