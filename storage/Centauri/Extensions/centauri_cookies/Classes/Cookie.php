<?php
namespace Centauri\Extension\Cookie;

use Centauri\CMS\Centauri;
use Centauri\CMS\Resolver\ViewResolver;

class Cookie
{
    /**
     * The model namespace.
     * 
     * @var string
     */
    private $parentModelNamespace = "\Centauri\Extension\Cookie\Models\ParentCookieModel";

    /**
     * The model namespace.
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
        /**
         * Parent-Cookie Model
         */
        $GLOBALS["Centauri"]["Models"][$this->parentModelNamespace] = [
            "namespace" => $this->parentModelNamespace,
            "id" => "centauri_cookie_parent",
            "tab" => "general",
            "label" => "Centauri » Cookies",
            "listLabel" => "{name}",

            "fields" => [
                "name" => [
                    "type" => "input",
                    "label" => trans("centauri_cookie::backend/global.label.name")
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
                    "newItemLabel" => "Cookie",
                    "existingItemLabel" => "{label}",
                    "type" => "model",

                    "config" => [
                        "model" => $this->childModelNamespace,
                        "parent_uid" => "parent_uid",

                        "fields" => [
                            "name",
                            "host",
                            "duration",
                            "type",
                            "category",
                            "description"
                        ]
                    ]
                ]
            ]
        ];

        /**
         * Child-Cookie Model
         */
        $GLOBALS["Centauri"]["Models"][$this->childModelNamespace] = [
            "namespace" => $this->childModelNamespace,
            "id" => "centauri_cookie_child",
            "label" => "Cookies",
            "listLabel" => "{name}",
            "newItemLabel" => "Cookie",
            "existingItemLabel" => "{title}",
            "isChild" => true,

            "fields" => [
                "name" => [
                    "type" => "input",
                    "label" => "Name"
                ],

                "host" => [
                    "type" => "input",
                    "label" => "Host"
                ],

                "duration" => [
                    "type" => "input",
                    "label" => "Host"
                ],

                "type" => [
                    "type" => "input",
                    "label" => "Type"
                ],

                "category" => [
                    "type" => "input",
                    "label" => "Category"
                ],

                "description" => [
                    "type" => "RTE",
                    "label" => "Host"
                ]
            ]
        ];

        /**
         * Views registration via ViewResolver class
         */
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("centauri_cookie", "EXT:centauri_cookie/Views");
    }
}
