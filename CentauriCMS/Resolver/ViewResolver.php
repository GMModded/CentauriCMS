<?php
namespace Centauri\CMS\Resolver;

use Illuminate\Support\Facades\View;

class ViewResolver
{
    /**
     * Registers (more likely adds) the given string $namespace so it can be called using e.g.
     * - view($namespace . "news.blade.php")->render() which would render/return the output HTML code of the given namespace + news-blade (file name).
     * 
     * @param string $namespace The namespace/unique identifier for this view-namespace.
     * @param string $Path The path to this unique identifier/namespace.
     * 
     * @return void
     */
    public static function register(string $namespace, string $path)
    {
        $path = str_replace("EXT:", storage_path("Centauri/Extensions/"), $path);
        View::addNamespace($namespace, $path);

        $GLOBALS["Centauri"]["Helper"]["VariablesHelper"]["__LoadedViews"][$namespace] = $path;
    }
}
