<?php
namespace Centauri\CMS\Http;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Component\ElementComponent;
use Centauri\CMS\Model\Language;
use Illuminate\Support\Str;

class Request
{
    /**
     * This function manages all requests before anything else happens
     * 
     * @param string $view - Can be either frontend or backend/centauri
     * 
     * @return void
     */
    public static function handle($nodes)
    {
        if($nodes == "centauri") {
            if(request()->session()->get("CENTAURI_BE_USER")) {
                $Centauri = new Centauri();
                $data = $Centauri->initBE();

                return view("Backend.centauri", [
                    "data" => $data
                ]);
            }

            return view("Backend.login");
        }

        if(Str::contains($nodes, "/")) {
            $nnodes = explode("/", $nodes);

            if($nnodes[0] == "centauri") {
                if($nnodes[1] == "ajax" || $nnodes[1] == "action") {
                    $classname = $nnodes[2];
                    $method = $nnodes[3];

                    $namespace = "\\Centauri\\CMS\\";

                    switch($nnodes[1]) {
                        case "ajax":
                            $class = Centauri::makeInstance($namespace . "Ajax\\" . $classname . "Ajax");
                            $method = "request";
                            break;
                        default:
                            $class = Centauri::makeInstance($namespace . "Controller\\" . $classname . "Controller");
                            $method .= "Action";
                            break;
                    }

                    return call_user_func_array(
                        [
                            $class,
                            $method
                        ],

                        [
                            request(),
                            $nnodes[3]
                        ]
                    );
                }
            }
        }

        $page = null;

        if(Str::contains($nodes, "/") && $nodes != "/") {
            $page = Page::where("slugs", $nodes)->get()->first();
            $nodes = explode("/", $nodes);
        } else {
            $slugs = str_replace("/", "", $nodes);
            $page = Page::where("slugs", $slugs)->orWhere("slugs", "/" . $slugs)->get()->first();
        }

        self::throwNotFound(false, $page);

        $page = Page::find($page->uid);
        $uid = $page->getAttribute("uid");

        $renderedHTML = ElementComponent::render("FE", $uid);

        echo view("frontend", [
            "page" => $page,
            "content" => $renderedHTML
        ]);
    }

    public static function throwNotFound($force = false, $page = null)
    {
        $throwNotFound = false;

        if(!$force && is_null($page)) {
            $throwNotFound = true;
        } else if($force) {
            $throwNotFound = true;
        }

        if($throwNotFound) {
            dd("404");
        }
    }
}