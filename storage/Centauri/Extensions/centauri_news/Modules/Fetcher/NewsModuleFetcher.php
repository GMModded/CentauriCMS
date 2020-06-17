<?php
namespace Centauri\Extension\Fetcher;

use Centauri\Extension\Model\News;

class NewsModuleFetcher
{
    public $models;

    public function __construct()
    {
        $this->models = News::get()->all();
    }
}
