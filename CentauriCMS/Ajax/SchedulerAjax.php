<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Model\Scheduler;
use Centauri\CMS\Service\ExecuteSchedulerService;
use Centauri\CMS\Traits\AjaxTrait;
use Illuminate\Http\Request;

class SchedulerAjax
{
    use AjaxTrait;

    /**
     * Creation of new Scheduler-record.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function createAjax(Request $request)
    {
        $data = $request->input();
        $formData = json_decode($data["formData"]);

        $scheduler = new Scheduler;
        $scheduler->name = $formData->name;
        $scheduler->namespace = $formData->namespace;
        $scheduler->time = $formData->time;
        $scheduler->save();

        return json_encode([
            "type" => "success",
            "title" => $scheduler->name . "-Scheduler",
            "description" => "Scheduler successfully created"
        ]);
    }

    /**
     * Manual execution of a scheduler by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function executeAjax(Request $request)
    {
        $data = $request->input();
        $config = $data;
        $uid = $config["uid"];

        $params = $config;
        unset($params["uid"]);

        return ExecuteSchedulerService::execute($uid, $params);
    }

    /**
     * Returns a scheduler-record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function findByUidAjax(Request $request)
    {
        $data = $request->input();
        $uid = $data["uid"];
        $scheduler = Scheduler::where("uid", $uid)->get()->first();

        return $scheduler;
    }

    /**
     * Saves a scheduler-record by its uid.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function saveByUidAjax(Request $request)
    {
        $data = $request->input();
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

    /**
     * @deprecated This will be removed in version 1.1 of Centauri - migration will be an alternative way of storing those.
     * 
     * Returns all configured Schedulers inside Centauri's configuration file.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function getSchedulersAjax(Request $request)
    {
        $cfgSchedulers = config("centauri")["Schedulers"];
        $schedulers = [];

        foreach($cfgSchedulers as $label => $cfgScheduler) {
            $schedulers[] = [
                "name" => $label,
                "value" => $cfgScheduler
            ];
        }

        return json_encode($schedulers);
    }
}
