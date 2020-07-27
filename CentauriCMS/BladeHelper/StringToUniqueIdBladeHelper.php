<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;

/**
 * Renders a page by the given / its uid.
 * 
 * @method action
 * Example:
 *  <div>
 *      {!! StringToUniqueIdBladeHelper::conv("My awesome string") !!}
 *      // Output would be like "my-awesome-string"
 *  </div>
 */
class StringToUniqueIdBladeHelper
{
    /**
     * @param string $string The string to be converted into an unique readable id.
     * 
     * @return string
     */
    public static function conv($string, $separator = "-")
    {
        $accents_regex = "~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i";

        $special_cases = [
            "&" => "and",
            "'" => ""
        ];

        $string = mb_strtolower(trim($string), "UTF-8");
        $string = str_replace( array_keys($special_cases), array_values($special_cases), $string);
        $string = preg_replace( $accents_regex, "$1", htmlentities($string, ENT_QUOTES, "UTF-8") );
        $string = preg_replace("/[^a-z0-9]/u", $separator, $string);
        $string = preg_replace("/[$separator]+/u", $separator, $string);

        return $string;
    }
}
