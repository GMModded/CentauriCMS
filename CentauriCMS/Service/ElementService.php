<?php
namespace Centauri\CMS\Service;

class ElementService
{
    /**
     * @var $tabs array
     */
    private $tabs = [];

    /**
     * @var $fields array
     */
    private $fields = [];

    /**
     * @var $elements array
     */
    private $elements = [];

    /**
     * Getting all Tabs created by this class
     * 
     * @return array
     */
    public function getTabs()
    {
        return $this->tabs;
    }

    /**
     * Setting Tabs for this class
     * 
     * @return void
     */
    public function setTabs($tabs)
    {
        $this->tabs = $tabs;
    }

    /**
     * Getting all Fields created by this class
     * 
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * Setting Fields for this class
     * 
     * @return void
     */
    public function setFields($fields)
    {
        $this->fields = $fields;
    }

    /**
     * Getting all Elements created by this class
     * 
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * Setting Elements for this class
     * 
     * @return void
     */
    public function setElements($elements)
    {
        $this->elements = $elements;
    }
}