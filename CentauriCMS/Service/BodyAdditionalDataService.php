<?php
namespace Centauri\CMS\Service;

class BodyAdditionalDataService
{
    /**
     * @return void
     */
    public static function add($identifier, $class)
    {
        $GLOBALS["Centauri"]["AdditionalDataFuncs"]["Frontend"]["Tags"]["Body"][$identifier] = $class;
    }
}
