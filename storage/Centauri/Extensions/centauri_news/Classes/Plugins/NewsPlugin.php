<?php
namespace Centauri\Extension\News\Plugins;

use Centauri\CMS\PluginAbstract;
use Centauri\CMS\PluginInterface;
use Centauri\Extension\News\Model\NewsModel;

class NewsPlugin extends PluginAbstract implements PluginInterface
{
    public function __construct($plugin)
    {
        // $this->renderHtmlOnly = true;
        $this->pluginid = "centauri_news_pi1";
        $this->plugin = $plugin;

        $news = NewsModel::get()->all();

        $this->html = view("centauri_news::Frontend/list", [
            "news" => $news
        ])->render();
    }
}
