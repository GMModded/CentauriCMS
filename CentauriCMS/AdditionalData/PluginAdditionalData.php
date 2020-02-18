<?php
namespace Centauri\CMS\AdditionalDatas;

class PluginAdditionalDatas
{
    public function fetch()
    {
        return [
            "plugins" => $GLOBALS["Centauri"]["Plugins"]
        ];
    }
}
