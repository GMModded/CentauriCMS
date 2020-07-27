<?php
namespace Centauri\CMS\Abstracts;

class ExtensionAbstract
{
    /**
     * The extension key of this abstract.
     * 
     * @var string
     */
    private $extensionKey = "";

    /**
     * Sets this extension key.
     * 
     * @return void
     */
    public function setExtensionKey(string $extensionKey)
    {
        $this->extensionKey = $extensionKey;
    }

    /**
     * Returns the extension key.
     * 
     * @return string
     */
    public function getExtensionKey(): string
    {
        return $this->extensionKey;
    }
}
