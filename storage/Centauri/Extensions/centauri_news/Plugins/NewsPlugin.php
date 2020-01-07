<?php
namespace Centauri\Extension\Plugin;

use Centauri\CMS\PluginAbstract;
use Centauri\CMS\PluginInterface;

class NewsPlugin extends PluginAbstract implements PluginInterface
{
    public function __construct($plugin)
    {
        $this->pluginid = "centauri_news_pi1";
        $this->plugin = $plugin;

        $news = 

        $this->html = view("centauri_news::Frontend/list", [
            "news" => $news
        ])->render();
    }
}
