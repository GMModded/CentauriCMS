<?php
namespace Centauri\Extension\News\CME;

class NewsCME
{
    public function __construct($params)
    {
        $GLOBALS["Centauri"]["Models"][$params["modelNamespace"]] = [
            "namespace" => "centauri_news",
            "tab" => "general",
            "label" => "Centauri » News",
            "listLabel" => "{title} by <b>{author}</b>",

            "fields" => [
                "title" => [
                    "type" => "input",
                    "label" => trans("centauri_news::backend/global.label.title")
                ],

                "slug" => [
                    "type" => "input",
                    "label" => trans("centauri_news::backend/global.label.slug"),

                    "renderAs" => [
                        "type" => "button",
                        "action" => "generate-slug",
                        "sourceField" => "title"
                    ],

                    "config" => [
                        "required" => 1,
                        "readOnly" => 1
                    ]
                ],

                "author" => [
                    "type" => "input",
                    "label" => "Author"
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
    }
}
