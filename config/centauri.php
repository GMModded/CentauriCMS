<?php

return [
    "config" => [
        "cache" => true
    ],

    "beLayouts" => [
        "default" => [
            "label" => "backend/be_layout.layouts.default.label",

            "config" => [
                // rowPos - will be saved into the DB as key
                0 => [
                    // "cols" => Array
                    "cols" => [
                        // colPositions - will be saved into the DB as key
                        0 => [
                            "label" => "backend/be_layout.layouts.default.cols.content"
                        ]
                    ]
                ],

                1 => [
                    "cols" => [
                        2 => [
                            "label" => "AHHHH1"
                        ],
                        3 => [
                            "label" => "AHHHH2"
                        ]
                    ]
                ]
            ]
        ]
    ],

    # CentauriContentElements - CCE
    "CCE" => [
        "fields" => [
            "htag" => [
                "label" => "H-Tag",
                "type" => "select",

                "config" => [
                    // "default" => [
                    //     "H1",
                    //     "h1"
                    // ],
                    "required" => 1,

                    "items" => [
                        [
                            "H1",
                            "h1"
                        ],

                        [
                            "H2",
                            "h2"
                        ],

                        [
                            "H3",
                            "h3"
                        ],

                        [
                            "H4",
                            "h4"
                        ],

                        [
                            "H5",
                            "h5"
                        ],

                        [
                            "H6",
                            "h6"
                        ]
                    ]
                ]
            ],
            "header" => [
                "label" => "Header",
                "type" => "input",

                "config" => [
                    "required" => 1
                ]
            ],
            "subheader" => [
                "label" => "Subheader",
                "type" => "input"
            ],
            "rte" => [
                "label" => "RTE",
                "type" => "rte"
            ],
            "plugin" => [
                "label" => "Plugin",
                "type" => "plugin"
            ],
            "grid-container-full" => [
                "label" => "Container (Full)",
                "type" => "grid"
            ],
            "image" => [
                "label" => "Image",
                "type" => "image",

                "config" => [
                    "required" => 1,
                    "minItems" => 1,
                    "maxItems" => 1,
                ]
            ],
            "file" => [
                "label" => "File",
                "type" => "file",

                "config" => [
                    // "saveToColumn" => "file",
                    "required" => 1,
                    "maxItems" => 1
                ]
            ],
            "slideritems" => [
                "label" => "Slider-Items",
                "newItemLabel" => "Slider-Item",
                "existingItemLabel" => "{title}",
                "type" => "model",

                "config" => [
                    "model" => "\Centauri\CMS\Model\SliderItemModel",

                    "fields" => [
                        "image" => [
                            "label" => "Image",
                            "type" => "image",

                            "config" => [
                                "required" => 1,
                                "minItems" => 1,
                                "maxItems" => 1,
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

                        "slideritems_buttons" => [
                            "label" => "Buttons",
                            "newItemLabel" => "Button",
                            "existingItemLabel" => "{label}",
                            "type" => "model",

                            "config" => [
                                "model" => "\Centauri\CMS\Model\SliderItemButtonModel",
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
            ],
        ],

        "elements" => [
            "headerimage" => [
                "image",
                "header;subheader",
                "rte"
            ],

            "headerdescription" => [
                "htag;header;subheader",
                "rte"
            ],

            "slider" => [
                "slideritems"
            ],

            "plugin" => [
                "header;plugin"
            ],

            "grids" => [
                "grid-container-full"
            ]
        ],

        "tabs" => [
            "general" => [
                "label" => "backend/modals.newContentElement.Tabs.general",

                "elements" => [
                    "headerimage",
                    "slider",
                    "headerdescription"
                ]
            ],
            
            "special" => [
                "label" => "SPECIAL",

                "elements" => [
                    "plugin"
                ]
            ],

            "grids" => [
                "label" => "Grids",

                "elements" => [
                    "grids"
                ]
            ]
        ],

        "fieldConfiguration" => [
            "headerdescription" => [
                "select" => [
                    "label" => "woooow"
                ]
            ]
        ]
    ],

    # CentauriModelElements - CME
    "CME" => [
        "models" => [],

        "tabs" => [
            "general" => [
                "label" => "General",
                "models" => []
            ]
        ]
    ]
];
