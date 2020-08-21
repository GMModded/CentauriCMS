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
     * Constructor of this abstract class.
     * 
     * @return void
     */
    public function __construct()
    {
        $loader = (isset($params["loader"]) ? $params["loader"] : "default");

        if($loader != "default") {
            dd($this->$loader(), "LEL");
            return $this->$loader();
        }
    }

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

    /**
     * This method will only be called if Kernel-Level-Caching is inside "/config/centauri-server.php"-file is enabled.
     * Its purpose is simple - it can be used for e.g. registration of Kernel-Level-Hooks such as it actual purpose for the Caching itself.
     * Note that only this method is called during Kernel-Request and not the actual constructor.
     *
     * @return void
     */
    public function kernelRegistrationLoader()
    {
        return;
    }
}
