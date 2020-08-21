<?php
namespace Centauri\Extension\Cookie;

use Centauri\CMS\Abstracts\ExtensionAbstract;
use Centauri\CMS\Interfaces\ExtensionInterface;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\CMS\Service\BodyAdditionalDataService;
use Centauri\CMS\Service\HeadAdditionalDataService;

use \Centauri\Extension\Cookie\AdditionalDatas as CookieAdditionalDatas;

class Cookie extends ExtensionAbstract implements ExtensionInterface
{
    /**
     * The (parent) model namespace.
     * 
     * @var string
     */
    private $parentModelNamespace = "\Centauri\Extension\Cookie\Models\ParentCookieModel";

    /**
     * The (child) model namespace.
     * 
     * @var string
     */
    private $childModelNamespace = "\Centauri\Extension\Cookie\Models\ChildCookieModel";

    /**
     * Initialization of this Extension's main class.
     * 
     * @return void
     */
    public function init()
    {
        $this->setExtensionKey("centauri_cookies");

        /** Views registration for this extension */
        ViewResolver::register($this->getExtensionKey(), "EXT:" . $this->getExtensionKey() . "/Views");

        /** Cookies Plugin */
        $GLOBALS["Centauri"]["Plugins"][$this->getExtensionKey() . "_pi1"] = [
            "Cookies Plugin" => "\Centauri\Extension\Cookie\Plugins\CookiePlugin"
        ];

        /** Parent-Cookie Model */
        $GLOBALS["Centauri"]["Models"][$this->parentModelNamespace] = [
            "namespace" => $this->parentModelNamespace,
            "id" => "centauri_cookie_parent",
            "tab" => "general",
            "label" => "Centauri » Cookies",
            "listLabel" => "{name}",

            "fields" => [
                "name" => [
                    "type" => "input",
                    "label" => trans($this->getExtensionKey() . "::backend/global.label.name"),
                    "additionalClasses" => "preview-update-title"
                ],

                "teaser" => [
                    "type" => "RTE",
                    "label" => "Description"
                ],

                "state" => [
                    "type" => "checkbox",
                    "label" => "State"
                ],

                $this->childModelNamespace => [
                    "label" => "Cookies",
                    "listLabel" => "{name}",
                    "newItemLabel" => "Create new Cookie",
                    "existingItemLabel" => "{label}",
                    "type" => "model",

                    "config" => [
                        "model" => $this->childModelNamespace,
                        "parent_uid" => "parent_uid",

                        "fields" => [
                            "name",
                            "description"
                        ]
                    ]
                ]
            ]
        ];

        /** Child-Cookie Model */
        $GLOBALS["Centauri"]["Models"][$this->childModelNamespace] = [
            "namespace" => $this->childModelNamespace,
            "id" => "centauri_cookie_child",
            "label" => "Cookies",
            "listLabel" => "{name}",
            "newItemLabel" => "Create new Cookie",
            "existingItemLabel" => "{title}",
            "isChild" => true,

            "fields" => [
                "name" => [
                    "type" => "input",
                    "label" => "Name",
                    "additionalClasses" => "preview-update-title"
                ],

                "description" => [
                    "type" => "RTE",
                    "label" => "Description"
                ]
            ]
        ];

        /** Registration of additional head- and body-tags for CSS- and JS-file. */
        HeadAdditionalDataService::add("centauri_cookie", CookieAdditionalDatas\HeadTagAdditionalDatas::class);
        BodyAdditionalDataService::add("centauri_cookie", CookieAdditionalDatas\BodyTagAdditionalDatas::class);
    }
}
