<?php

namespace App\Providers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Loads localization files of all extensions
        $extensions = Storage::disk("centauri_extensions")->allDirectories();

        foreach($extensions as $extension) {
            if(!Str::contains($extension, "/")) {
                $extName = $extension;
                $extConfigFilePath = storage_path("Centauri/Extensions/$extName/ext_config.php");

                $config = require_once($extConfigFilePath);
                $localizationFolder = $config["localizationFolder"] ?? "Language";

                $this->loadTranslationsFrom(storage_path("Centauri/Extensions/$extName/$localizationFolder"), $extName);
           }
        }
    }
}
