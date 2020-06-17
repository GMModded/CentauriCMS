<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\BladeHelper\BuildBladeHelper;
use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Notification;
use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Helper\PageTreeHelper;
use Centauri\CMS\Model\File;
use Centauri\CMS\Model\Form;
use Centauri\CMS\Model\Scheduler;
use Centauri\CMS\Utility\DomainsUtility;
use Illuminate\Support\Facades\Storage;

class ModulesService
{
    /**
     * Init method of this class
     * 
     * @return void
     */
    public function init()
    {
        $modules = [
            "dashboard" => [
                "title" => trans("backend/modules.dashboard.title"),
                "icon" => "fas fa-tachometer-alt"
            ],

            "pages" => [
                "title" => trans("backend/modules.pages.title"),
                "icon" => "fas fa-file-alt"
            ],

            "domains" => [
                "title" => "Domains",
                "icon" => "fas fa-globe"
            ],

            "languages" => [
                "title" => trans("backend/modules.languages.title"),
                "icon" => "fas fa-language"
            ],

            "models" => [
                "title" => trans("backend/modules.models.title"),
                "icon" => "fas fa-plus"
            ],

            "forms" => [
                "title" => "Forms",
                "icon" => "fab fa-wpforms"
            ],

            /*
            "filelist" => [
                "title" => trans("backend/modules.filelist.title"),
                "icon" => "fas fa-cloud-upload-alt"
            ],
            */

            "extensions" => [
                "title" => trans("backend/modules.extensions.title"),
                "icon" => "fas fa-boxes"
            ],

            "notifications" => [
                "title" => trans("backend/modules.notifications.title"),
                "icon" => "fas fa-bell"
            ],

            "system" => [
                "title" => trans("backend/modules.system.title"),
                "icon" => "fas fa-server"
            ],

            "schedulers" => [
                "title" => trans("backend/modules.scheduler.title"),
                "icon" => "fas fa-clock"
            ],
        ];

        foreach($modules as $moduleid => $data) {
            $icon = "fas fa-box";

            if(!isset($data["icon"])) {
                if(Storage::exists("icon-" . $moduleid)) {
                    $icon = Storage::get("icon_" . $moduleid);
                }
            } else {
                $icon = "<i class='" . $data["icon"] . "'></i>";
            }

            $modules[$moduleid]["icon"] = $icon;
        }

        $modules["notifications"]["data"] = Notification::get()->count();

        $extensionModules = $GLOBALS["Centauri"]["Modules"];
        $GLOBALS["Centauri"]["Modules"] = array_merge($modules, $extensionModules);
    }

    /**
     * Handles different dynamic data for every single module in the backend
     * 
     * @param string $moduleid - The ID of the module (attribute: data-moduleid) e.g. "dashboard" or "pages" etc.
     * @return array
     */
    public function findDataByModuleid($moduleid)
    {
        $__notification = null;
        $data = [];

        if($moduleid == "dashboard") {
            $domains = count(DomainsUtility::findAll());
            $pages = Page::all()->count();
            $languages = Language::all()->count();
            $notifications = Notification::all()->count();

            $data = [
                "pages" => $pages,
                "domains" => $domains,
                "languages" => $languages,
                "notifications" => $notifications
            ];
        }

        if($moduleid == "pages") {
            $languages = Language::all();
            $lid = LanguageService::getLanguage();

            $pages = BuildBladeHelper::treeByPid(0, null, $lid);
            $pageTreeHTML = PageTreeHelper::buildTreeHTML($pages);

            $data = [
                "pageTreeHTML" => $pageTreeHTML,
                "languages" => $languages
            ];
        }

        if($moduleid == "domains") {
            $domainFiles = DomainsUtility::findAll();

            $data = [
                "domainFiles" => $domainFiles
            ];
        }

        if($moduleid == "languages") {
            $languages = Language::all();

            $data = [
                "languages" => $languages
            ];
        }

        if($moduleid == "models") {
            $models = collect();

            foreach($GLOBALS["Centauri"]["Models"] as $key => $model) {
                $models[$key] = [
                    "label" => $model["label"],
                    "loaded" => (class_exists($key))
                ];
            }

            $data = [
                "models" => $models
            ];
        }

        if($moduleid == "forms") {
            $forms = Form::get()->all();

            $data = [
                "forms" => $forms
            ];

            // $tabs = config("centauri")["forms"]["tabs"];

            // $data = [
            //     "tabs" => $tabs
            // ];
        }

        if($moduleid == "filelist") {
            $files = File::get()->all();

            $nFiles = [];
            foreach($files as $file) {
                $path = storage_path("Centauri\\Filelist\\" . $file->name);

                if(file_exists($path)) {
                    $nFile = [
                        "uid" => $file->uid,
                        "name" => $file->name,
                        "cropable" => $file->cropable,
                        "path" => env("APP_URL") . "/storage/Centauri/Filelist/" . $file->name,
                        "URLpath" => env("APP_URL") . "/storage/Centauri/Filelist/" . $file->name,
                        "type" => $file->type,
                        "size" => filesize($path)
                    ];
    
                    $nFiles[] = $nFile;
                } else {
                    $notification = new Notification;

                    $notification->severity = "ERROR";
                    $notification->title = "File '" . $path . "' not found";
                    $notification->text = "Please make sure this file exists either or delete it by using the Fix-Utility.";

                    $notification->save();

                    echo "<script id='_'>
                        Centauri.Components.ModulesComponent({
                            type: 'load',
                            module: 'notifications',

                            cb: function() {
                                $('tr:first-child').css('border', '3px solid gold');
                                $('tr:first-child').css('transition', '.3s');

                                setTimeout(function() {
                                    $('tr:first-child').css('border', '3px solid transparent');
                                }, 300);
                            }
                        });
                        
                        setTimeout(function() {
                            $('script#_').remove();
                        }, 500);
                    </script>";
                }
            }

            $data = [
                "files" => $nFiles
            ];
        }

        if($moduleid == "selectfilefromlist") {
            $data = [

            ];
        }

        if($moduleid == "extensions") {
            Centauri::makeInstance(ExtensionsComponent::class);

            $extensions = [];
            foreach($GLOBALS["Centauri"]["Extensions"] as $extKey => $ext) {
                if(!isset($ext["state"])) {
                    $ext["state"] = "UNKNOWN";
                }

                $extensions[$extKey] = $ext;
            }

            $data = [
                "extensions" => $extensions
            ];
        }

        if($moduleid == "notifications") {
            $notifications = Notification::all();

            $data = [
                "notifications" => $notifications
            ];
        }

        if($moduleid == "sites") {
            $data = [
                "a" => "b"
            ];
        }

        if($moduleid == "schedulers") {
            $schedulers = Scheduler::get()->all();

            $data = [
                "schedulers" => $schedulers
            ];
        }

        else {
            if(isset($GLOBALS["Centauri"]["Modules"][$moduleid]["DataFetcher"])) {
                $data = Centauri::makeInstance($GLOBALS["Centauri"]["Modules"][$moduleid]["DataFetcher"]);
            }
        }

        if(gettype($data) == "array") {
            if(isset($data["languages"]) && gettype($data["languages"]) != "integer") {
                foreach($languages as $language) {
                    $flagsrc = env("APP_URL") . "/" . $language->getAttribute("flagsrc");
                    $language->setAttribute("flagsrc", $flagsrc);
                }
            }
        }

        if(!is_null($__notification)) {
            $data["__notification"] = $__notification;
        }

        return $data;
    }
}
