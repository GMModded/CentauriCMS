<?php
namespace Centauri\CMS;

use Centauri\CMS\CentauriServer\ExtensionsLoader;
use Centauri\CMS\CentauriServer\KernelLevelCaching;

class CentauriServer
{
    /**
     * Configuration array of "/config/centauri-server.php"-file.
     * 
     * @var array
     */
    protected $config = null;

    /**
     * KernelLevelCaching class.
     * 
     * @var KernelLevelCaching
     * @inject
     */
    protected $kernelLevelCaching = null;

    /**
     * ExtensionsLoader class.
     * 
     * @var ExtensionsLoader
     * @inject
     */
    protected $extensionsLoader = null;

    /**
     * Constructor of this class.
     * Sets the config-property of itself to the array of the "/config/centauri-server.php"-file.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->config = require __DIR__ . "/../../config/centauri-server.php";
    }

    /**
     * Init method which SHOULD ONLY be used inside the index.php file - to hold things clean.
     * 
     * @return array|bool
     */
    public function init()
    {
        $config = $this->getConfig();

        $this->extensionsLoader = Centauri::makeInstance(ExtensionsLoader::class);
        $this->extensionsLoader->load();

        if($config["KERNEL_LEVEL_CACHING"]["status"]) {
            $this->kernelLevelCaching = Centauri::makeInstance(KernelLevelCaching::class);
            $config["KERNEL_LEVEL_CACHING"]["__handle"] = $this->kernelLevelCaching->handle();
        }

        return $config;
    }

    /**
     * Returns the configuration array - if the $key is given, then as json_decoded-value.
     * 
     * @param null|string $key Optionally the key for the configuration-array.
     * 
     * @return array|json_decode
     */
    public function getConfig($key = null)
    {
        if(!is_null($key)) {
            return json_decode(json_encode($this->config[$key]));
        }

        return $this->config;
    }
}
