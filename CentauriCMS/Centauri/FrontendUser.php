<?php
namespace Centauri\CMS;

class FrontendUser
{
    /**
     * Determine if the current frontend user is logged in or not.
     *
     * @return bool
     */
    public function loggedIn()
    {
        if(is_null(session()->get("FRONTEND_USER"))) {
            return false;
        }

        return true;
    }

    /**
     * Retrieves the current frontend user.
     * 
     * @return null|void
     */
    public function getUser()
    {
        return session()->get("FRONTEND_USER");
    }
}
