<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Centauri;
use Centauri\CMS\Service\ModulesService;
use Centauri\CMS\Traits\AjaxTrait;
use Illuminate\Http\Request;

class ModulesAjax
{
    use AjaxTrait;

    /**
     * This modules service.
     * 
     * @var object $modulesService
     */
    private $modulesService;

    /**
     * Constructor for this class.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->modulesService = Centauri::makeInstance(ModulesService::class);
    }

    /**
     * Shows the content of a module.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return void
     */
    public function showAjax(Request $request)
    {
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
}
