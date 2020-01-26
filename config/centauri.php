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
                "label" => "aaa",
                "type" => "select",

                "config" => [
                    "items" => [
                        [
                            "label" => "labelellll",
                            "value" => "valueueue"
                        ],

                        [
                            "label" => "2222",
                            "value" => "2222"
                        ]
                    ]
                ]
            ],
            "header" => [
                "label" => "Header",
                "type" => "input"
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
