<?php
namespace Centauri\Extension\Jobs\Plugins;

use Centauri\CMS\PluginAbstract;
use Centauri\CMS\PluginInterface;
use Centauri\Extension\Jobs\Model\JobsModel;

class JobsPlugin extends PluginAbstract implements PluginInterface
{
    public function __construct($plugin)
    {
        // $this->renderHtmlOnly = true;
        $this->pluginid = "centauri_jobs_pi1";
        $this->plugin = $plugin;

        $jobs = JobsModel::get()->all();

        $this->html = view("centauri_jobs::Frontend/list", [
            "jobs" => $jobs
        ])->render();
    }
}
