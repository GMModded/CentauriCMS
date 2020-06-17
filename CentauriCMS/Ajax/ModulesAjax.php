<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\AjaxAbstract;
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
        if($ajaxName == "show") {
            $moduleid = $request->input("moduleid");
            $data = $this->modulesService->findDataByModuleid($moduleid);

            $loadedViews = $GLOBALS["Centauri"]["Helper"]["VariablesHelper"]["__LoadedViews"] ?? [];
            $namespace = "";

            foreach($loadedViews as $key => $loadedView) {
                if(view()->exists($key . "::Backend.Modules.$moduleid")) {
                    $namespace = $key;
                    break;
                }
            }

            // if(!view()->exists($namespace . "::" . $moduleid) && !view()->exists("Centauri::Backend.Modules.$moduleid")) {
            //     return response("Template for Module '" . $moduleid . "' not found!", 500);
            // }

            $bladeNamespace = "Centauri";
            if($namespace != "") {
                $bladeNamespace = $namespace;
            }

            if(request()->has("uid")) {
                $data["__uid"] = request()->input("uid");
            }

            return view($bladeNamespace . "::Backend.Modules.$moduleid", [
                "data" => $data
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
