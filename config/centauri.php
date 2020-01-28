<?php

return [
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
                ]
            ]
        ]
    ],

    # CentauriContentElements - CCE
    "CCE" => [
        "fields" => [
            "htag" => [
                "label" => "Select",
                "type" => "select",

                "config" => [
                    "required" => 1,
                    // "default" => [
                    //     "defaultLabel",
                    //     "defaultValue"
                    // ],

                    "items" => [
                        [
                            "Item 1", // Label
                            "item_1" // Value
                        ],

                        [
                            "Item 2",
                            "item_2"
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
                "type" => "RTE"
            ],
            "plugin" => [
                "label" => "Plugin",
                "type" => "plugin"
            ],
            "image" => [
                "label" => "Image",
                "type" => "image",

                "config" => [
                    "required" => 1,
                    "minItems" => 1,
                    "maxItems" => 1,
                ],
            ],
            "file" => [
                "label" => "File",
                "type" => "file",

                "config" => [
                    // "saveToColumn" => "file",
                    "required" => 1,
                    "maxItems" => 1
                ]
            ]/*,
            "image" => [
                "label" => "Image",
                "type" => "image",

                "config" => [
                    "type" => "image",
                    "required" => 1,
                    "maxItems" => 1
                ]
            ]*/
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

            "plugin" => [
                "header;plugin"
            ]
        ],

        "tabs" => [
            "general" => [
                "label" => "backend/modals.newContentElement.Tabs.general",
                "elements" => [
                    "headerimage",
                    "headerdescription",
                    "plugin"
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
