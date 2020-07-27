<?php
namespace Centauri\Extension\Frontend\BladeHelper;

class GradientBladeHelper
{
    public static function gradient(Array $start, Array $end)
    {
        $gradient = $start["deg"] . "deg, " . $start["color"] . $start["width"] . ",";
        $gradient .= $end["deg"] . "deg, " . $end["color"] . $end["width"];

        return "linear-gradient(" . $gradient . ")";
    }
}
