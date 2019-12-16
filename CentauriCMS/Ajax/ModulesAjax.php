<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxInterface;
use Centauri\CMS\Centauri;
use Centauri\CMS\Service\ModulesService;
use Illuminate\Http\Request;

class ModulesAjax implements AjaxInterface
{
    private $modulesService;

    public function __construct()
    {
        $this->modulesService = Centauri::makeInstance(ModulesService::class);
    }

    public function request(Request $request, String $ajaxName)
    {
        $moduleid = $request->input("moduleid");

        $data = $this->modulesService->findDataByModuleid($moduleid);

        if(!view()->exists("Backend.Modules.$moduleid")) {
            return response("Template for Module '" . $moduleid . "' not found!", 500)->header("Content-Type", "text/json");
        }

        return view("Backend.Modules.$moduleid", [
            "data" => $data
        ]);
    }
}
