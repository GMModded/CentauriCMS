<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Abstracts\AjaxAbstract;
use Centauri\CMS\Centauri;
use Illuminate\Http\Request;
use Centauri\CMS\Interfaces\AjaxInterface;
use Centauri\CMS\Model\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class DatabaseAjax extends ServiceProvider implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "update") {
            $path = base_path("CentauriCMS/SQL");

            $sqlInstance = Centauri::makeInstance(\Centauri\CMS\SQL::class);
            dd($sqlInstance);

            // Laoding SQL files from Centauri-Core first
            // foreach($sqlFiles as $sqlFile) {
                // $path = base_path("CentauriCMS/SQL/" . $sqlFile);
                // require_once($path);
                // DB::unprepared(file_get_contents($path));
            // }

            // Loading SQL files from extensions
            // $extensionsDirs = Storage::disk("centauri_extensions")->allDirectories();
            // $extensionsFiles = Storage::disk("centauri_extensions")->allFiles();

            // $extensions = [];//array_merge($extensionsDirs, $extensionsFiles);

            // foreach($extensions as $extension) {
            //     if(!Str::contains($extension, "/")) {
            //         $extSQLFiles = Storage::disk("centauri_extensions")->allFiles("/$extension/Classes/SQL");

            //         foreach($extSQLFiles as $extSQLFile) {
            //             $extSQLPath = storage_path("Centauri/Extensions/$extSQLFile");
            //             require_once($extSQLPath);
                        // DB::unprepared(file_get_contents($extSQLPath));
            //         }
            //     }
            // }

            return json_encode([
                "type" => "success",
                "title" => "Database updated",
                "description" => "All SQL queries has been successfully executed!"
            ]);
        }

        if($ajaxName == "syncFiles") {
            $files = Storage::disk("centauri_filelist")->allFiles();
            DB::table("files")->truncate();

            foreach($files as $fileItem) {
                $path = Storage::disk("centauri_filelist")->path($fileItem);
                $mimeType = \Illuminate\Support\Facades\File::mimeType($path);

                $storagePath = "\\storage\\Centauri\\Filelist\\$fileItem";

                $cropable = 0;
                if(Str::contains($mimeType, "image")) {
                    $cropable = 1;
                }

                $file = new File();

                $file->name = $fileItem;
                $file->path = $storagePath;
                $file->type = $mimeType;
                $file->cropable = $cropable;

                $file->save();
            }

            return json_encode([
                "type" => "success",
                "title" => "Files synced",
                "description" => "All SQL queries for the files table has been successfully executed!"
            ]);
        }

        return AjaxAbstract::default($request, $ajaxName);
    }
}
