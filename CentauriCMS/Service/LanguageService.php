<?php
namespace Centauri\CMS\Service;

class LanguageService
{
    private static $sessLanguageKey = "CENTAURI_BE_LANGUAGE";

    /**
     * Returns current language view in BE context.
     * 
     * @return integer|void
     */
    public static function getLanguage()
    {
        return session()->get(self::$sessLanguageKey);
    }

    /**
     * Sets the language in the BE context of the current session.
     * 
     * @param integer $lid - Language ID
     * 
     * @return boolean|void
     */
    public static function setLanguage($lid)
    {
        return session()->put(self::$sessLanguageKey, $lid);
    }
}
