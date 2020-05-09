<?php
namespace Centauri\Extension\Frontend\Elements;

class Elements
{
    public function __construct()
    {
        $tabs = [
            "centaurifrontend_elements" => [
                "label" => "Elements",

                "elements" => [
                    "headerdescription",
                    "slider"
                ]
            ]
        ];

        $fields = [
            "slideritems" => [
                "label" => "Slider-Items",
                "newItemLabel" => "Slider-Item",
                "existingItemLabel" => "{title}",
                "type" => "model",

                "config" => [
                    "model" => \Centauri\Extension\Frontend\Model\SliderItemModel::class,

                    "fields" => [
                        "image" => [
                            "label" => "Image",
                            "type" => "image",

                            "config" => [
                                "required" => 1,
                                "minItems" => 1,
                                "maxItems" => 1,
                                "validation" => \Centauri\CMS\Validation\FileValidation::class
                            ]
                        ],

                        "title" => [
                            "label" => "Title",
                            "type" => "input",

                            "config" => [
                                "required" => 1
                            ]
                        ],

                        "teasertext" => [
                            "label" => "Teaser-Text",
                            "type" => "input",

                            "config" => [
                                "required" => 1
                            ]
                        ],

                        "link" => [
                            "label" => "Link",
                            "type" => "input",
                        ],

                        "slideritems_buttons" => [
                            "label" => "Buttons",
                            "newItemLabel" => "Button",
                            "existingItemLabel" => "{label}",
                            "type" => "model",

                            "config" => [
                                "model" => \Centauri\Extension\Frontend\Model\SliderItemButtonModel::class,
                                "parent_uid" => "parent_uid",

                                "fields" => [
                                    "label",
                                    "link",
                                    "bgcolor",
                                ]
                            ]
                        ],
                    ]
                ]
            ],
            "slideritems_buttons" => [
                "config" => [
                    "model" => \Centauri\Extension\Frontend\Model\SliderItemButtonModel::class,

                    "fields" => [
                        "label" => [
                            "label" => "Label",
                            "type" => "input"
                        ],

                        "link" => [
                            "label" => "Link",
                            "type" => "input"
                        ],

                        "bgcolor" => [
                            "label" => "Background-Color",
                            "type" => "input",
                            "renderAs" => "colorpicker"
                        ],
                    ]
                ]
            ]
        ];

        $elements = [
            "headerdescription" => [
                "htag;header;subheader",
                "RTE"
            ],

            "slider" => [
                "slideritems"
            ]
        ];

        $GLOBALS["Centauri"]["ContentElements"]["centauri_frontend"] = [
            "order" => "FIRST",
            "tabs" => $tabs,
            "fields" => $fields,
            "elements" => $elements
        ];
    }
}
