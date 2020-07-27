<?php
namespace Centauri\CMS\Exception;

use Exception;
use Illuminate\Http\Response;

class CentauriException
{
    /**
     * Handles/Throwing of exceptions since the backend is meant to show only user-friendly toastr-errors, if any.
     * 
     * @param string $message The message for this exception/response.
     * @param boolean $forceException Optional for forcing while being in Backend an exception instead of the toastr-notification.
     * 
     * @return Exception|Response
     */
    public function throw($message, $forceException = false)
    {
        session()->put("CENTAURI_EXCEPTION", 1);

        if(!$forceException && request()->ajax()) {
            return response($message);
        }

        throw new Exception($message, 0);
    }
}
