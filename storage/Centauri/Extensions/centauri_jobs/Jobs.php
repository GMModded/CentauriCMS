<?php
namespace Centauri\Extension\Jobs;

use Centauri\CMS\Centauri;
use Centauri\CMS\Helper\GetModelBySlugHelper;
use Centauri\CMS\Http\FrontendRenderingHandler;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Resolver\ViewResolver;
use Centauri\Extension\Jobs\Handler\JobsRoutesHandler;
use Centauri\Extension\Jobs\Model\JobsModel;

class Jobs
{
    private $modelNamespace = "\Centauri\Extension\Jobs\Model\JobsModel";

    public function __construct()
    {
        /**
         * Backend Jobs Module
         */
        // Centauri::makeInstance(JobsModule::class);

        /**
         * Jobs Plugin
         */
        $GLOBALS["Centauri"]["Plugins"]["centauri_jobs_pi1"] = [
            "Jobs Plugin" => "\Centauri\Extension\Plugin\JobsPlugin"
        ];

        /**
         * Jobs Model
         */
        $GLOBALS["Centauri"]["Models"][$this->modelNamespace] = [
            "namespace" => "centauri_jobs",
            "tab" => "general",
            "label" => "Centauri » Jobs",
            "listLabel" => "{name}",

            "fields" => [
                "name" => [
                    "type" => "input",
                    "label" => trans("centauri_jobs::backend/global.label.name")
                ],

                "slug" => [
                    "type" => "input",
                    "label" => trans("centauri_jobs::backend/global.label.slug"),

                    "renderAs" => [
                        "type" => "button",
                        "action" => "generate-slug",
                        "sourceField" => "name"
                    ],

                    "config" => [
                        "required" => 1,
                        "readOnly" => 1
                    ]
                ],

                "headerimage" => [
                    "type" => "image",
                    "label" => "Headerimage"
                ],

                "description" => [
                    "type" => "RTE",
                    "label" => "Description"
                ]
            ]
        ];

        /**
         * Views registration via ViewResolver class
         */
        $ViewResolver = Centauri::makeInstance(ViewResolver::class);
        $ViewResolver->register("centauri_jobs", "EXT:centauri_jobs/Views");

        /**
         * JobsRoutesHandler
         */
        Centauri::makeInstance(JobsRoutesHandler::class, [
            "modelNamespace" => $this->modelNamespace
        ]);
    }

    public function showAction($parameters)
    {
        dd($parameters);
        $uid = $parameters["uid"];
        $job = JobsModel::where("uid", $uid)->get()->first();

        dd("lmao showaction");

        return view("centauri_jobs::Frontend/show", [
            "job" => $job
        ])->render();
    }
}
