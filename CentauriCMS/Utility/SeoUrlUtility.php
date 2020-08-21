<?php
namespace Centauri\CMS\Utility;

class SeoUrlUtility
{
    /**
     * This method will convert a (maybe non-readable) URL into a clean and seo-friendly URL.
     * 
     * @param string $string The URL-string to be cleaned.
     * @param string $separator Optional, the seperator between each slug-word.
     * 
     * @return string
     */
    public static function slugify($string, $separator = "-")
    {
        $accents_regex = "~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i";

        $special_cases = [
            "&" => "and",
            "'" => ""
        ];

        $string = mb_strtolower(trim($string), "UTF-8");
        $string = str_replace(array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace($accents_regex, "$1", htmlentities($string, ENT_QUOTES, "UTF-8"));
        $string = preg_replace("/[^a-z0-9]/u", $separator, $string);

        if($separator != "") {
            $string = preg_replace("/[$separator]+/u", $separator, $string);
        }

        return $string;
    }
}
