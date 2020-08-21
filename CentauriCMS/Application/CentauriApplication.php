<?php
namespace Centauri\CMS\Application;

use \Centauri\CMS\AdditionalDatas;

class CentauriApplication
{
    /**
     * This is Centauri's Core array.
     * 
     * Extensions may manipulate e.g. AdditionalDatas with their own Datas by hooking
     * into the CentauriApplication class and update the public-array $this->Centauri.
     * 
     * @var array
     */
    public $Centauri = [];

    /**
     * The constructor for this Centauri application.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->Centauri = [
            /** Backend Modules on the left-side */
            "Modules" => [],

            /** Content-Elements - mainly used inside ContentElementsAjax class */
            "ContentElements" => [],

            /** 
             * Additional Data is a powerful component in Centauri for both frontend and backend - you can herefor manipulate element/data-values
             * BEFORE they're getting actually rendered
             */
            "AdditionalDataFuncs" => [
                "Frontend" => [
                    "Tags" => [
                        "Head" => [
                            AdditionalDatas\HeadTagAdditionalDatas::class
                        ],

                        "Body" => []
                    ]
                ],

                "ContentElements" => [
                    "plugin" => [
                        "class" => AdditionalDatas\PluginAdditionalDatas::class
                    ],

                    "grid" => [
                        "class" => AdditionalDatas\GridAdditionalDatas::class,
                        "return_statement" => 1
                    ]
                ]
            ],

            /** This array is helpful when trying to analyze/debug if e.g. an extension is found AND loaded by Centauri's ExtensionComponent class */
            "Extensions" => [],

            /** This array is helpful when trying to analyze/debug if e.g. a model is found AND loaded by Centauri's ModelsHelper and similiar classes */
            "Models" => [],

            /** This array is mainly for the PluginAdditionalDatas class */
            "Plugins" => [],

            /**
             * Processors are kinda the same way how AdditionalData working - the only and also big difference is that it's the only class which
             * handles for both before and after the possibility to manipulate an element before rendering - and also just for the frontend view
             */
            "Processors" => [
                "__before" => [],
                "__after" => []
            ],

            /** Handlers are only made for the purpose on HTTP-Request level "actions" */
            "Handlers" => [
                "pageNotFound" => \Centauri\CMS\Http\PageNotFound::class,

                /**
                 * Extendable by extensions and loaded (as also cached) by CentauriRoutes.php file
                 * 
                 * This can be used to show by a specific slug e.g. "/news/{title}" to force fetch the news record and render a show-/detail-view */
                "routes" => []
            ],

            /** Some helpers for e.g. globals-sub-array to avoid having generic names for $GLOBALS array */
            "Helper" => [
                "VariablesHelper" => [
                    "__ContentElementsAjax__IteratorForFields" => 0,
                    "__LoadedViews" => []
                ]
            ],

            "Hooks" => [
                "Cache" => [
                    "KernelStaticFileCache" => [
                        "setCache" => [],
                        "getCache" => []
                    ]
                ]
            ],

            /** Initialized by PathService class */
            "Paths" => [
                "BaseURL" => ""
            ]
        ];

        return $this->Centauri;
    }
}
