<?php
namespace Vendor\Name\Elements;

class TestElement
{
    public function __construct()
    {
        $tabs = [
            "customtab" => [
                "label" => "Custom Tab",
                "elements" => [
                    "customelement"
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
            "customelement" => [
                "customheaderfield"
            ]
        ];

        $GLOBALS["Centauri"]["ContentElements"]["mytestext"]["order"] = "FIRST";
        $GLOBALS["Centauri"]["ContentElements"]["mytestext"]["tabs"] = $tabs;
        $GLOBALS["Centauri"]["ContentElements"]["mytestext"]["fields"] = $fields;
        $GLOBALS["Centauri"]["ContentElements"]["mytestext"]["elements"] = $elements;
    }
}
