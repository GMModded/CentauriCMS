<?php
namespace Centauri\CMS\Helper;

class CCEHelper
{
    public static function getAllFields()
    {
        $CCE = config("centauri")["CCE"];
        $CCEfields = $CCE["fields"];

        $_fields = [];
        foreach($GLOBALS["Centauri"]["ContentElements"] as $extension => $arr) {
            if(isset($arr["fields"])) {
                foreach($arr["fields"] as $fieldCtype => $fieldArr) {
                    $_fields[$fieldCtype] = $fieldArr;
                }
            }
        }

        $extensionsCME = $GLOBALS["Centauri"]["Models"];

        foreach($extensionsCME as $key => $extCMEArr) {
            $_fields[$extCMEArr["namespace"]] = $extCMEArr;
        }

        $CCEfields = array_merge($_fields, $CCEfields);
        return $CCEfields;
    }

    public static function getAllElements()
    {
        $CCE = config("centauri")["CCE"];
        $CEEelements = $CCE["elements"];

        $_elements = [];
        foreach($GLOBALS["Centauri"]["ContentElements"] as $extension => $arr) {
            if(isset($arr["elements"])) {
                foreach($arr["elements"] as $fieldCtype => $fieldArr) {
                    $_elements[$fieldCtype] = $fieldArr;
                }
            }
        }

        $CEEelements = array_merge($_elements, $CEEelements);
        return $CEEelements;
    }
}
