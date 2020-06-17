<?php
namespace Centauri\CMS\BladeHelper;

/**
 * Usage:
 * {!! LanguageSwitchBladeHelper::to(1) !!}
 * 
 */

class LanguageSwitchBladeHelper
{
    public static function to($lid)
    {
        request()->session("lid", $lid);
        return redirect(request()->url());
    }
}
