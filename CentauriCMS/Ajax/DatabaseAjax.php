<?php
namespace Centauri\CMS\Ajax;

use Centauri\CMS\Centauri;
use Illuminate\Http\Request;
use Centauri\CMS\Model\File;
use Centauri\CMS\Traits\AjaxTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class DatabaseAjax extends ServiceProvider
{
    use AjaxTrait;

    /**
     * Method when updating the database (by loading Centauri's Core aswell as third-party-extension sql-files).
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function updateAjax(Request $request)
    {
        /**
         * DB::unprepared(file_get_contents($path)); -> loads a .sql-file
         * require_once($path); -> loads a .php-file
         */


        $sqlFiles = Storage::disk("centauri_core_sql")->allFiles();

        // Laoding SQL files from Centauri-Core first
        foreach($sqlFiles as $sqlFile) {
            $path = base_path("CentauriCMS/SQL/" . $sqlFile);
            require_once($path);
        }

        // Loading SQL files from extensions
        $extensionsDirs = Storage::disk("centauri_extensions")->allDirectories();
        $extensionsFiles = Storage::disk("centauri_extensions")->allFiles("SQL");

        $extensions = array_merge($extensionsDirs, $extensionsFiles);

        foreach($extensions as $extension) {
            if(!Str::contains($extension, "/")) {
                $extSQLFiles = Storage::disk("centauri_extensions")->allFiles("/$extension/Classes/SQL");

                foreach($extSQLFiles as $extSQLFile) {
                    $extSQLPath = storage_path("Centauri/Extensions/$extSQLFile");

                    if(\Illuminate\Support\Str::endsWith($extSQLPath, ".php")) {
                        require_once($extSQLPath);
                    }
                }
            }
        }

        return json_encode([
            "type" => "success",
            "title" => "Database updated",
            "description" => "All SQL queries has been successfully executed!"
        ]);
    }

    /**
     * Method when synchronizing the storages within their files.
     * 
     * @param Request $request The request object given by the request-method above.
     * 
     * @return json|response
     */
    public function syncFilesAjax(Request $request)
    {
        $files = Storage::disk("centauri_filelist")->allFiles();
        DB::table("files")->truncate();

        foreach($files as $fileItem) {
            $path = Storage::disk("centauri_filelist")->path($fileItem);
            $mimeType = \Illuminate\Support\Facades\File::mimeType($path);

            $storagePath = "/storage/Centauri/Filelist/";

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
}
