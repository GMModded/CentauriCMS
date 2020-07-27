<?php
namespace Centauri\Extension\Frontend\Service;

use Centauri\Extension\Frontend\BladeHelper;

class LoadBladeHelpersService
{
    public function __construct()
    {
        $bladeHelpers = [
            "GradientBladeHelper" => BladeHelper\GradientBladeHelper::class
        ];

        return $bladeHelpers;
    }
}
