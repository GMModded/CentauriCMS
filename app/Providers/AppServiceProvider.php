<?php

namespace App\Providers;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ExtensionsComponent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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
        $extensionsComponent = Centauri::makeInstance(ExtensionsComponent::class);
        $extensionsComponent->loadExtensions();

        Blade::directive("images", function($fileReference) {
            dd($fileReference);
        });

        // // Loads localization files of all extensions
        // $extensions = Storage::disk("centauri_extensions")->allDirectories();

        // foreach($extensions as $extension) {
        //     if(!Str::contains($extension, "/")) {
        //         $extName = $extension;
        //         $extConfigFilePath = storage_path("Centauri/Extensions/$extName/ext_config.php");

        //         $config = require_once($extConfigFilePath);
        //         $localizationFolder = $config["localizationFolder"] ?? "Language";

        //         $this->loadTranslationsFrom(storage_path("Centauri/Extensions/$extName/$localizationFolder"), $extName);
        //    }
        // }
    }
}
