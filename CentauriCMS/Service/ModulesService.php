<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Notification;
use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Model\File;
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

            "filelist" => [
                "title" => trans("backend/modules.filelist.title"),
                "icon" => "fas fa-cloud-upload-alt"
            ],

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

            $pages = Page::get()->all();
            $npages = [];

            $domainFiles = DomainsUtility::findAll();

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
                        if($page->is_rootpage) {
                            $domainFileForUidExists = false;

                            foreach($domainFiles as $domainFile) {
                                if($domainFile->content->rootpageuid == $page->uid) {
                                    $page->slugs = $domainFile->content->domain;
                                    $domainFileForUidExists = true;
                                }
                            }

                            if(!$domainFileForUidExists) {
                                echo "<script id='_'>Centauri.Notify('primary', 'Domains', 'Please create a new domain-record for your new rootpage <br><i>" . $page->title . " [" . $language->title . " - #" . $page->uid . "]</i>, so it can be connected.', {timeOut: 20000});$('script#_').remove();</script>";
                                break;
                            }
                        }

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

        if($moduleid == "sites") {
            $data = [
                "a" => "b"
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
