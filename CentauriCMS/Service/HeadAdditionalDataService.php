<?php
namespace Centauri\CMS\Service;

class HeadAdditionalDataService
{
    /**
     * @return void
     */
    public static function add($identifier, $class)
    {
        $GLOBALS["Centauri"]["AdditionalDataFuncs"]["Frontend"]["Tags"]["Head"][$identifier] = $class;
    }
}
