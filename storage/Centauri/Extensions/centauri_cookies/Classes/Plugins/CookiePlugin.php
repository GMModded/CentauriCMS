<?php
namespace Centauri\Extension\Cookie\Plugins;

use Centauri\CMS\Abstracts\PluginAbstract;
use Centauri\Extension\Cookie\Models\ParentCookieModel;

class CookiePlugin extends PluginAbstract
{
    public function __construct($plugin)
    {
        $this->pluginid = "centauri_cookies_pi1";
        $this->plugin = $plugin;

        $cookies = ParentCookieModel::get()->all();

        $this->html = view("centauri_cookies::Frontend.list", [
            "cookies" => $cookies
        ])->render();
    }
}
