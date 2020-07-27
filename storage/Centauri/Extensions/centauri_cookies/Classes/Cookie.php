<?php
namespace Centauri\Extension\Cookie;

use Centauri\CMS\Resolver\ViewResolver;
use Exception;

class Cookie
{
    private $extKey = "centauri_cookies";

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
     * The constructor for this extension.
     * 
     * @return void
     */
    public function __construct()
    {
        /** Views registration for this extension */
        ViewResolver::register($this->extKey, "EXT:" . $this->extKey . "/Views");

        /** Cookies Plugin */
        $GLOBALS["Centauri"]["Plugins"][$this->extKey . "_pi1"] = [
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
                    "label" => trans($this->extKey . "::backend/global.label.name"),
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

        /** Registration of additional head tag for CSS file */
        $GLOBALS["Centauri"]["AdditionalDataFuncs"]["Frontend"]["Tags"]["Head"][] = \Centauri\Extension\Cookie\AdditionalDatas\HeadTagAdditionalDatas::class;

        /** Registration of additional body tag for JS file */
        $GLOBALS["Centauri"]["AdditionalDataFuncs"]["Frontend"]["Tags"]["Body"][] = \Centauri\Extension\Cookie\AdditionalDatas\BodyTagAdditionalDatas::class;
    }
}
