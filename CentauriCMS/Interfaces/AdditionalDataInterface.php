<?php
namespace Centauri\CMS\Interfaces;

interface AdditionalDataInterface
{
    /**
     * Fetch-method which is required when creating a new element of any specific type, it will return Additional-Data.
     * 
     * @return void
     */
    public function fetch();

    /**
     * Handle custom use-cases on edit
     * 
     * @param array $element
     * 
     * @return void
     */
    public function onEditListener($element);
}
