<?php
namespace Centauri\CMS\Service;

class MinifyHTMLService
{
    static protected $search = [
        '/(\n|^)(\x20+|\t)/',
        '/(\n|^)\/\/(.*?)(\n|$)/',
        '/\n/',
        '/\<\!--.*?-->/',
        '/(\x20+|\t)/', # Delete multispace (Without \n)
        '/\>\s+\</', # strip whitespaces between tags
        '/(\"|\')\s+\>/', # strip whitespaces between quotation ("') and end tags
        '/=\s+(\"|\')/' # strip whitespaces between = "'
    ];

    static protected $replace = [
        "\n",
        "\n",
        " ",
        "",
        " ",
        "><",
        "$1>",
        "=$1"
    ];

    public static function minify($html)
    {
        $html = preg_replace(self::$search, self::$replace, $html);
        return $html;
    }
}
