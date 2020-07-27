<?php

$gridLayoutFieldsDefaultConfig = [
    "grid_fullsize;grid_space_top;grid_space_bottom"
];

/** Centauri Core/Main Configuration */
return [

    /** @see https://docs.centauricms.de/config/caching */
    "config" => [

        /** @see https://docs.centauricms.de/config/caching */
        "Caching" => [
            "state" => true,
            "type" => "STATIC_FILE_CACHE", # DEFAULT or STATIC_FILE_CACHE
            "imagesToBase64" => true
        ],

        /** @see https://docs.centauricms.de/config/frontend */
        "FE" => [
            # "Default" in case a beLayout has no "template"-definition so it will use this one as default.
            "DefaultMainTemplate" => "centauri_frontend::Frontend.Templates.frontend",
            "keepSiteAlive" => true
        ]
    ],

    /** Backend Layouts */
    "beLayouts" => [
        "default" => [
            /** NOTE: When using AdditionalDatas within the same class here, those additionaldata calls has to be moved into the static rendering method! */
            "rendering" => \Centauri\Extension\Frontend\Frontend::class,
            "template" => "centauri_frontend::Frontend.Templates.Page.frontend",
            "label" => "backend/be_layout.layouts.default.label",

            "config" => [
                /** rowPos - will be saved into the DB as key */
                0 => [
                    /** "cols" => Array */
                    "cols" => [
                        /** colPositions - will be saved into the DB as key */
                        0 => [
                            "label" => "backend/be_layout.layouts.default.cols.content"
                        ]
                    ]
                ]
            ]
        ]
    ],

    /** Grids */
    "grids" => [
        "config" => [
            "templateRootPath" => "EXT:centauri_frontend"
        ]
    ],

    /** Grid-Layouts */
    "gridLayouts" => [
        "onecol" => [
            "label" => " » One Column Container",

            "config" => [
                /** rowPos - will be saved into the DB as key */
                0 => [
                    /** "cols" => Array */
                    "cols" => [
                        /** colPositions - will be saved into the DB as key */
                        0 => [
                            "label" => "backend/be_layout.layouts.default.cols.content"
                        ]
                    ]
                ]
            ],

            "gridFieldsConfig" => $gridLayoutFieldsDefaultConfig
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
            ],

            "gridFieldsConfig" => $gridLayoutFieldsDefaultConfig
        ]
    ],

    /** CentauriContentElements - CCE */
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
                    "maxItems" => 2,
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

            "grid_fullsize" => [
                "label" => "Container Fullsize?",
                "type" => "checkbox",
                "colAdditionalClasses" => "d-flex align-items-center"
            ],

            "grid_space_top" => [
                "label" => "Top Space",
                "type" => "select",

                "config" => [
                    "items" => [
                        ["MT-1", "mt-1"],
                        ["MT-2", "mt-2"],
                        ["MT-3", "mt-3"],
                        ["MT-4", "mt-4"],
                        ["MT-5", "mt-5"]
                    ]
                ]
            ],

            "grid_space_bottom" => [
                "label" => "Bottom Space",
                "type" => "select",

                "config" => [
                    "items" => [
                        ["MB-1", "mb-1"],
                        ["MB-2", "mb-2"],
                        ["MB-3", "mb-3"],
                        ["MB-4", "mb-4"],
                        ["MB-5", "mb-5"]
                    ]
                ]
            ]
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

    /** CentauriModelElements - CME */
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

    /** SQL Files */
    "SQLFiles" => [
        // \Centauri\CMS\SQL\PagesSQL::class,
        \Centauri\CMS\SQL\TestSQL::class
    ]
];
