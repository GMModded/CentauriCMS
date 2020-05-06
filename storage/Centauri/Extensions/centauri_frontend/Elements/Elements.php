<?php
namespace Centauri\Extension\Frontend\Elements;

class Elements
{
    public function __construct()
    {
        $tabs = [
            "centaurifrontend_elements" => [
                "label" => "Elements",

                "elements" => [
                    "headerdescription"
                ]
            ]
        ];

        $fields = [
            "customheaderfield" => [
                "label" => "Custom Header",
                "type" => "input"
            ]
        ];

        $elements = [
            "headerdescription" => [
                "customheaderfield"
            ]
        ];

        $GLOBALS["Centauri"]["ContentElements"]["centauri_frontend"] = [
            "order" => "FIRST",
            "tabs" => $tabs,
            "fields" => $fields,
            "elements" => $elements
        ];
    }
}
