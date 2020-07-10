<?php

return [
    /**
     * Centauri Core/Main Configuration
     */
    "config" => [
        "Caching" => [
            "state" => true,
            "type" => "STATIC_FILE_CACHE" # DEFAULT or STATIC_FILE_CACHE
        ],

        "FE" => [
            # "Default" in case a beLayout has no "template"-definition so it will use this one as default.
            "DefaultMainTemplate" => "centauri_frontend::Frontend.Templates.frontend",
            "keepSiteAlive" => false
        ]
    ],

    /**
     * Backend Layouts
     */
    "beLayouts" => [
        "default" => [
            "rendering" => \Centauri\Extension\Frontend\Frontend::class,
            "template" => "centauri_frontend::Frontend.Templates.Page.frontend",
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

    /**
     * Grids
     */
    "grids" => [
        "config" => [
            "templateRootPath" => "EXT:centauri_frontend"
        ],

        "layouts" => [
            "onecol" => [
                "label" => " » One Column Container",

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
            ],

            "twocol" => [
                "label" => " » Two Column Container",

                "config" => [
                    0 => [
                        "cols" => [
                            0 => [
                                "col" => "6",
                                "label" => "Left"
                            ],

                            1 => [
                                "col" => "6",
                                "label" => "Right"
                            ]
                        ]
                    ]
                ]
            ]
        ]
    ],

    /**
     * Grid-Layouts
     */
    "gridLayouts" => [
        "onecol" => [
            "label" => " » One Column Container",

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
        ],

        "twocol" => [
            "label" => " » Two Column Container",

            "config" => [
                0 => [
                    "cols" => [
                        0 => [
                            "col" => "6",
                            "label" => "Left"
                        ],

                        1 => [
                            "col" => "6",
                            "label" => "Right"
                        ]
                    ]
                ]
            ]
        ]
    ],

    /**
     * CentauriContentElements - CCE
     */
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
            "RTE" => [
                "label" => "RTE",
                "type" => "RTE"
            ],
            "plugin" => [
                "label" => "Plugin",
                "type" => "plugin"
            ],
            "grid" => [
                "label" => "Container (Full)",
                "type" => "grid",
                "additionalType" => "grid",
                "return_statement" => "MERGE"
            ],
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
            "file" => [
                "label" => "File",
                "type" => "file",

                "config" => [
                    "required" => 1,
                    "maxItems" => 1
                ]
            ],
            "colorpicker" => [
                "label" => "Color",
                "type" => "input",
                "renderAs" => "colorpicker"
            ],
        ],

        "elements" => [
            // "headerimage" => [
            //     "image",
            //     "header;subheader",
            //     "RTE"
            // ],

            "plugin" => [
                "header;plugin"
            ],

            "grids" => [
                "grid"
            ]
        ],

        "tabs" => [
            "general" => [
                "label" => "backend/modals.newContentElement.Tabs.general",

                "elements" => [
                    // "headerimage"
                ]
            ],

            "special" => [
                "label" => "backend/modals.newContentElement.Tabs.special",

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

        // "fieldConfiguration" => [
            // "headerimage" => [
            //     "select" => [
            //         "label" => "woooow"
            //     ]
            // ]
        // ]
    ],

    /**
     * CentauriModelElements - CME
     */
    "CME" => [
        "models" => [],

        "tabs" => [
            "general" => [
                "label" => "General",
                "models" => []
            ]
        ]
    ],

    "Schedulers" => [
        "Backup" => \Centauri\CMS\Scheduler\BackupScheduler::class,
        "Page-Indexer" => \Centauri\CMS\Scheduler\PageIndexScheduler::class
    ],

    // "Forms" => [
    //     "tabs" => [
    //         "inputs" => [
    //             "label" => "Inputs",

    //             "fields" => [
    //                 "row" => [
    //                     "HTMLType" => "HTML",
    //                     "type" => "row",
    //                     "html" => "<div class='row'><div class='col-12 col-lg-6'></div><div class='col-12 col-lg-6'></div></div>",

    //                     "config" => [
    //                         "intern_label" => "Row",
    //                     ]
    //                 ],

    //                 "input" => [
    //                     "HTMLType" => "input",
    //                     "type" => "text",

    //                     "config" => [
    //                         "label" => "Input",
    //                         "placeholder" => "Input"
    //                     ]
    //                 ],

    //                 "textarea" => [
    //                     "HTMLType" => "textarea",

    //                     "config" => [
    //                         "label" => "Textarea",
    //                         "placeholder" => "Textarea",
    //                         "rows" => "5"
    //                     ]
    //                 ]
    //             ]
    //         ],

    //         "radiocheckboxes" => [
    //             "label" => "Radio/Checkboxes",

    //             "fields" => [
    //                 "radio" => [
    //                     "HTMLType" => "input",
    //                     "type" => "radio",

    //                     "config" => [
    //                         "label" => "Lmao"
    //                     ]
    //                 ]
    //             ]
    //         ],

    //         "texts" => [
    //             "label" => "Texts",

    //             "fields" => [
    //                 "h4" => [
    //                     "HTMLType" => "HTML",
    //                     "type" => "TextTag",
    //                     "html" => "<h4 class='m-0'>H4</h4>"
    //                 ],
    //                 "h5" => [
    //                     "HTMLType" => "HTML",
    //                     "type" => "TextTag",
    //                     "html" => "<h5 class='m-0'>H5</h5>"
    //                 ],
    //                 "h6" => [
    //                     "HTMLType" => "HTML",
    //                     "type" => "TextTag",
    //                     "html" => "<h6 class='m-0'>H6</h6>"
    //                 ],
    //                 "p" => [
    //                     "HTMLType" => "HTML",
    //                     "type" => "TextTag",
    //                     "html" => "<p class='m-0'>P</p>"
    //                 ]
    //             ]
    //         ]
    //     ]
    // ],

    /**
     * SQL Files
     */
    "SQLFiles" => [
        // \Centauri\CMS\SQL\PagesSQL::class,
        \Centauri\CMS\SQL\TestSQL::class
    ]
];
