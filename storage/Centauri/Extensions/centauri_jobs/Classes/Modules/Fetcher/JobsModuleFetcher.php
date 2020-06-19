<?php
namespace Centauri\Extension\Fetcher;

use Centauri\Extension\Model\JobsModel;

class JobsModuleFetcher
{
    public $models;

    public function __construct()
    {
        $this->models = JobsModel::get()->all();
    }
}
