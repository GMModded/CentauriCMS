<?php
namespace Centauri\CMS\Exception;

use Exception;

class CentauriException extends \Exception
{
    public function __construct($message, $code = 0)
    {
        session()->put("CENTAURI_EXCEPTION", 1);
        throw new Exception($message, $code);
    }
}
