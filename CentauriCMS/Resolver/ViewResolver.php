<?php
namespace Centauri\CMS\Resolver;

use Illuminate\Support\Facades\View;

class ViewResolver
{
    public function register($namespace, $path)
    {
        $path = str_replace("EXT:", storage_path("Centauri/Extensions/"), $path);
        View::addNamespace($namespace, $path);

        $GLOBALS["Centauri"]["Helper"]["VariablesHelper"]["__LoadedViews"][$namespace] = $path;
    }
}
