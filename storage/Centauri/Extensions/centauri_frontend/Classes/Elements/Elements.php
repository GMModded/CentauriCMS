<?php
namespace Centauri\Extension\Frontend\Elements;

use Centauri\CMS\Centauri;
use Centauri\CMS\Service\ElementService;

class Elements
{
    /**
     * ElementService class instance.
     * 
     * @var ElementService
     */
    public $ElementService;

    /**
     * Constructor for this Elements class.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->ElementService = Centauri::makeInstance(ElementService::class);

        $this->ElementService->setTabs([
            "centaurifrontend_elements" => [
                "label" => "Elements",

                "elements" => [
                    "headerdescription",
                    "slider",
                    "headerimage",
                    "titleteaser",
                    "boxitems"
                ]
            ]
        ]);

        $this->ElementService->setFields([
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

                        "bgcolor" => [
                            "label" => "Background-Color",
                            "type" => "input",
                            "renderAs" => [
                                "type" => "colorpicker"
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
                        ]
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
                            "renderAs" => [
                                "type" => "colorpicker"
                            ]
                        ]
                    ]
                ]
            ],

            "boxitems" => [
                "label" => "Box-Items",
                "newItemLabel" => "Box-Item",
                "existingItemLabel" => "{title}",
                "type" => "model",

                "config" => [
                    "model" => \Centauri\Extension\Frontend\Model\BoxitemModel::class,

                    "fields" => [
                        "icon" => [
                            "label" => "Icon",
                            "type" => "image",

                            "config" => [
                                "maxItems" => 1,
                                "validation" => \Centauri\CMS\Validation\FileValidation::class
                            ]
                        ],

                        "link_label" => [
                            "label" => "Link - Label",
                            "type" => "input"
                        ],

                        "link" => [
                            "label" => "Link",
                            "type" => "input"
                        ],

                        "header" => [
                            "label" => "Header",
                            "type" => "input",

                            "config" => [
                                "required" => 1
                            ]
                        ],

                        "description" => [
                            "label" => "Description",
                            "type" => "RTE"
                        ],

                        "col_desktop" => [
                            "label" => "Size (Desktop)",
                            "type" => "input"
                        ],

                        "bgcolor_start" => [
                            "label" => "Background-Color - Gradient - Start",
                            "type" => "input",
                            "renderAs" => [
                                "type" => "colorpicker"
                            ]
                        ],

                        "bgcolor_end" => [
                            "label" => "Background-Color - Gradient - End",
                            "type" => "input",
                            "renderAs" => [
                                "type" => "colorpicker"
                            ]
                        ]
                    ]
                ]
            ],

            "bgoverlayer" => [
                "label" => "Background Overlayer",
                "type" => "input",
                "renderAs" => [
                    "type" => "colorpicker"
                ]
            ],

            "slug" => [
                "type" => "input",
                "label" => "SLUG YA KOSOMK",

                "renderAs" => [
                    "type" => "button",
                    "action" => "generate-slug",
                    "sourceField" => "header",
                    "iconClass" => "fas fa-sync-alt"
                ],

                "config" => [
                    "required" => 1,
                    "readOnly" => 1
                ]
            ],
        ]);

        $this->ElementService->setElements([
            "headerdescription" => [
                "htag;header;subheader",
                "RTE"
            ],

            "slider" => [
                "slideritems"
            ],

            "headerimage" => [
                "image",
                "header;subheader",
                "bgoverlayer;slug",
                "RTE"
            ],

            "titleteaser" => [
                "header;colorpicker"
            ],

            "boxitems" => [
                "boxitems"
            ]
        ]);

        $GLOBALS["Centauri"]["ContentElements"]["centauri_frontend"] = [
            "order" => "FIRST",
            "tabs" => $this->ElementService->getTabs(),
            "fields" => $this->ElementService->getFields(),
            "elements" => $this->ElementService->getElements()
        ];
    }
}
