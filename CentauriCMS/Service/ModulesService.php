<?php
namespace Centauri\CMS\Service;

use Centauri\CMS\BladeHelper\BuildBladeHelper;
use Centauri\CMS\Centauri;
use Centauri\CMS\Model\Page;
use Centauri\CMS\Model\Language;
use Centauri\CMS\Model\Notification;
use Centauri\CMS\Component\ExtensionsComponent;
use Centauri\CMS\Helper\PageTreeHelper;
use Centauri\CMS\Model\BeUser;
use Centauri\CMS\Model\File;
use Centauri\CMS\Model\Form;
use Centauri\CMS\Model\Scheduler;
use Centauri\CMS\Utility\DomainsUtility;
use Illuminate\Support\Facades\Log;
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

            "content" => [
                "label" => "Content",

                "modules" => [
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
                    ]
                ]
            ],

            "tools" => [
                "label" => "Tools",

                "modules" => [
                    "filelist" => [
                        "title" => trans("backend/modules.filelist.title"),
                        "icon" => "fas fa-cloud-upload-alt"
                    ],

                    "forms" => [
                        "title" => "Forms",
                        "icon" => "fab fa-wpforms"
                    ]
                ]
            ],

            "administration" => [
                "label" => "Administration",

                "modules" => [
                    "notifications" => [
                        "title" => trans("backend/modules.notifications.title"),
                        "icon" => "fas fa-bell",
                        "data" => Notification::get()->count()
                    ],

                    "extensions" => [
                        "title" => trans("backend/modules.extensions.title"),
                        "icon" => "fas fa-boxes"
                    ],

                    "system" => [
                        "title" => trans("backend/modules.system.title"),
                        "icon" => "fas fa-server"
                    ],

                    "schedulers" => [
                        "title" => trans("backend/modules.scheduler.title"),
                        "icon" => "fas fa-clock"
                    ]
                ]
            ],

            "user_and_permissions" => [
                "label" => "Users & Groups-Permissions",

                "modules" => [
                    "be_users" => [
                        "title" => trans("backend/modules.be_users.title"),
                        "icon" => "fas fa-users"
                    ],

                    "user_permission_groups" => [
                        "title" => trans("backend/modules.user_permission_groups.title"),
                        "icon" => "fas fa-stream"
                    ]
                ]
            ]
        ];

        foreach($modules as $moduleid => $data) {
            $isGrouped = isset($data["modules"]) ?? true;

            if($isGrouped) {
                foreach($data["modules"] as $groupedModuleid => $groupedModuleData) {
                    if($groupedModuleid != "type") {
                        $icon = "fas fa-box";

                        if(!isset($groupedModuleData["icon"])) {
                            if(Storage::exists("icon-" . $groupedModuleid)) {
                                $icon = Storage::get("icon_" . $groupedModuleid);
                            }
                        } else {
                            $icon = "<i class='" . $groupedModuleData["icon"] . "'></i>";
                        }

                        $modules[$moduleid]["modules"][$groupedModuleid]["icon"] = $icon;
                    }
                }
            } else {
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
        }

        $extensionModules = $GLOBALS["Centauri"]["Modules"] ?? [];
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
            $models = [];

            foreach($GLOBALS["Centauri"]["Models"] as $key => $model) {
                if(isset($model["isChild"]) && (!($model["isChild"])) || !isset($model["isChild"])) {
                    $items = $key::get()->count();

                    $models[$key] = [
                        "label" => $model["label"],
                        "loaded" => class_exists($key),
                        "items" => $items
                    ];
                }
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
            $files = Storage::disk("centauri_filelist")->allFiles();

            foreach($files as $key => $file) {
                $path = Storage::disk("centauri_filelist")->url($file);

                if(!Storage::disk("centauri_filelist")->exists($file)) {
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

                    break;
                }

                $relPath = storage_path("Centauri/Filelist/$file");
                $relPath = str_replace("/app", "", $relPath);
                $relPath = str_replace("/", "\\", $relPath);

                $fileModel = File::where("path", $relPath)->get()->first();

                $files[$key] = $fileModel;
            }

            $data = [
                "files" => $files
            ];
        }

        if($moduleid == "selectfilefromlist") {
            $data = [

            ];
        }

        if($moduleid == "extensions") {
            Centauri::makeInstance(ExtensionsComponent::class)->loadExtensions();

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

        if($moduleid == "be_users") {
            $beusers = BeUser::get()->all();

            $data = [
                "beusers" => $beusers
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
