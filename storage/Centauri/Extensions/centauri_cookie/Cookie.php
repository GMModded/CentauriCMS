<?php
namespace Centauri\Extension\Cookie;

use Centauri\CMS\Centauri;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Cookie\Models\CookieModel;

class Cookie
{
    private $modelNamespace = "\Centauri\Extension\Cookie\Models\CookieModel";

    public function __construct()
    {
        /**
         * Cookie Model
         */
        $GLOBALS["Centauri"]["Models"][$this->modelNamespace] = [
            "namespace" => "centauri_cookie",
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

                "cookies" => [
                    "label" => "Cookies",
                    "type" => "model",
                    "newItemLabel" => "Cookie",
                    "existingItemLabel" => "{title}",

                    "config" => [
                        "model" => \Centauri\Extension\Cookie\Model\CookieModel::class,

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
                    ]
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
