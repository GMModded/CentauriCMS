<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\BladeHelper;
use Centauri\CMS\Helper;

class LoadBladeHelpersService
{
    public function __construct()
    {
        $bladeHelpers = [
            "ImageBladeHelper" => BladeHelper\ImageBladeHelper::class,
            "BuildBladeHelper" => BladeHelper\BuildBladeHelper::class,
            "URIBladeHelper" => BladeHelper\URIBladeHelper::class,
            "TreeHelper" => Helper\TreeHelper::class
        ];

        return $bladeHelpers;
    }
}
