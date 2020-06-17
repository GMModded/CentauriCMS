<?php
namespace Centauri\CMS\Helper;

class ControllerURLParamsHelper
{
    public $params;
    public $url;

    public function __construct($controllerName)
    {
        $url = request()->path();
        $this->url = $url;

        $url = str_replace("centauri/action/" . $controllerName . "/", "", $url);
        $splitted = explode("/", $url);

        $params = [];
        foreach($splitted as $key => $segment) {
            if($key != 0) {
                $params[$splitted[$key - 1]] = $segment;
            }
        }

        $this->params = $params;
    }

    public function getParam($param)
    {
        return $this->params[$param];
    }
}
