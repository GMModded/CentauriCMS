<?php
namespace Centauri\CMS;

interface TrackingInterface
{
    /**
     * Method when the Tracker has to save data
     * Must return a boolean to handle in case it fails or when it has been successfully saved
     * 
     * @param mixin &$data
     * @return boolean
     */
    public function save($data);

    /**
     * Method when the Tracker has data and can return them
     * 
     * @return mixin
     */
    public function get();
}
