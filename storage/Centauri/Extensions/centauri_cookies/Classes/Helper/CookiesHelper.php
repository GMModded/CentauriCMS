<?php
namespace Centauri\Extension\Cookie\Helper;

class CookiesHelper
{
    /**
     * This method will check whether the client (browser) accepted the cookiebox yet or not.
     * 
     * @return bool
     */
    public static function getConsentState()
    {
        $cookies = [];
        $httpCookieStr = ($_SERVER["HTTP_COOKIE"] ?? "");

        $cookiebox = false;

        if(\Illuminate\Support\Str::contains($httpCookieStr, "; ")) {
            $_cookies = explode("; ", $httpCookieStr);

            foreach($_cookies as $index => $cookieStr) {
                $cookies[explode("=", $cookieStr)[0]] = explode("=", $cookieStr)[1];
            }

            $cookiebox = array_key_exists("cookiebox", $cookies);
        }

        return (bool) $cookiebox;
    }
}
