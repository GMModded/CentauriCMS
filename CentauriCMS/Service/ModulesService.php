<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Notification;
use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Model\File;
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

            "models" => [
                "title" => trans("backend/modules.models.title"),
                "icon" => "fas fa-plus"
            ],

            "filelist" => [
                "title" => trans("backend/modules.filelist.title"),
                "icon" => "fas fa-cloud-upload-alt"
            ],

            "languages" => [
                "title" => trans("backend/modules.languages.title"),
                "icon" => "fas fa-language"
            ],

            "extensions" => [
                "title" => trans("backend/modules.extensions.title"),
                "icon" => "fas fa-boxes"
            ],

            "notifications" => [
                "title" => trans("backend/modules.notifications.title"),
                "icon" => "fas fa-bell"
            ],

            "database" => [
                "title" => trans("backend/modules.database.title"),
                "icon" => "fas fa-database"
            ]
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
            $rootpages = Page::where("is_rootpage", "1")->get()->count();
            $pages = Page::where("is_rootpage", "0")->get()->count();
            $languages = Language::all()->count();
            $notifications = Notification::all()->count();

            $data = [
                "rootpages" => $rootpages,
                "pages" => $pages,
                "languages" => $languages,
                "notifications" => $notifications
            ];
        }

        if($moduleid == "pages") {
            $languages = Language::all();

            $pages = Page::get()->all();
            $npages = [];

            foreach($pages as $page) {
                if($page->getAttribute("is_rootpage")) {
                    $language = Language::where("uid", $page->lid)->get()->first();

                    if(is_null($language)) {
                        $notification = new Notification;

                        $notification->severity = "WARN";
                        $notification->title = "Page with lid '" . $page->lid . "' doesn't exists";
                        $notification->text = "This issue may caused by removing a language-entry from the 'languages' table.";

                        $notification->save();
                    } else {
                        $flagsrc = env("APP_URL") . "/" . $language->flagsrc;
                        $language->flagsrc = $flagsrc;
    
                        $page->setAttribute("language", $language);
                        $npages[$page->getAttribute("lid")][$page->getAttribute("uid")][] = $page;
                    }
                }
            }
            foreach($pages as $page) {
                if(!$page->getAttribute("is_rootpage")) {
                    $language = Language::where("uid", $page->lid)->get()->first();

                    if(is_null($language)) {
                        $notification = new Notification;

                        $notification->severity = "WARN";
                        $notification->title = "Page with lid '" . $page->lid . "' doesn't exists";
                        $notification->text = "This issue may caused by removing a language-entry from the 'languages' table.";

                        $notification->save();
                    } else {
                        $flagsrc = env("APP_URL") . "/" . $language->flagsrc;
                        $language->flagsrc = $flagsrc;
    
                        $page->setAttribute("language", $language);
                        $npages[$page->getAttribute("lid")][$page->getAttribute("pid")][] = $page;
                    }
                }
            }

            if(is_null($npages) || empty($npages) && !empty($pages)) {
                $__notification = [
                    "severity" => "ERROR",
                    "title" => "Page(s) with a language which doesn't exists anymore",
                    "text" => "Delete remaining pages which has a connection to the non-existing language to fix this issue.",
                    "html" => "<a href='" . url("./centauri/fix/deletePagesWithNotExistingLanguage") . "'><button class='btn btn-warn waves-effect waves-light'>Fix issue</button></a>"
                ];
            }

            $data = [
                "pages" => $npages,
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

        if($moduleid == "filelist") {
            $files = File::get()->all();

            $nFiles = [];
            foreach($files as $file) {
                $nFile = [
                    "uid" => $file->uid,
                    "name" => $file->name,
                    "cropable" => $file->cropable,
                    "path" => $_ENV["APP_URL"] . "/storage/Centauri/Filelist/" . $file->name,
                    "URLpath" => $_ENV["APP_URL"] . "/storage/Centauri/Filelist/" . $file->name,
                    "type" => $file->type,
                    "size" => filesize(storage_path("Centauri\\Filelist\\" . $file->name))
                ];

                $nFiles[] = $nFile;
            }

            $data = [
                "files" => $nFiles
            ];
        }

        if($moduleid == "selectfilefromlist") {
            $data = [

            ];
        }

        if($moduleid == "languages") {
            $languages = Language::all();

            $data = [
                "languages" => $languages
            ];
        }

        if($moduleid == "extensions") {
            Centauri::makeInstance(ExtensionsComponent::class);

            $extensions = [];
            foreach($GLOBALS["Centauri"]["Extensions"] as $extKey => $ext) {
                if(!isset($ext["state"])) {
                    $ext["state"] = "Beta";
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
