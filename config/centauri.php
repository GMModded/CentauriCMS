<?php

return [
    "languages" => [
        "en",
        "de"
    ],

    "beLayouts" => [
        "default" => [
            "label" => "backend/be_layout.layouts.default.label",

            "config" => [
                // rowPos
                0 => [
                    "label" => "backend/be_layout.layouts.default.cols.content",

                    // Column Definitions - either => string OR => array
                    "cols" => [
                        0 => "",
                        1 => ""
                    ],

                    /**
                     * Example with custom col-width (using Bootstrap 4 inside template)

                    "cols" => [
                        0 => [
                            "col" => "6"
                        ],

                        1 => ""
                    ]
                    */
                ]
            ]
        ],

        ""
    ],

    "CCE" => [
        "fields" => [
            "header" => [
                "col" => "6",
                "label" => "Header",
                "type" => "input"
            ],
            "subheader" => [
                "col" => "6",
                "label" => "Subheader",
                "type" => "input"
            ],
            "rte" => [
                "col" => "6",
                "label" => "RTE",
                "type" => "RTE"
            ],
        ],

        "tabs" => [
            "general" => [
                "label" => "backend/modals.newContentElement.Tabs.general",

                "fields" => [
                    "headerdescription" => [
                        "header;subheader",
                        "rte"
                    ]
                ]
            ]
        ]
    ]
];
