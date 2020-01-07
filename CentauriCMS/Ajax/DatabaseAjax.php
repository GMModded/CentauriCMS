<?php
namespace Centauri\CMS\Ajax;

use Illuminate\Http\Request;
use Centauri\CMS\AjaxInterface;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseAjax implements AjaxInterface
{
    public function request(Request $request, String $ajaxName)
    {
        if($ajaxName == "update") {
            $sqlFiles = Storage::disk("centauri_core_sql")->allFiles();

            // Laoding SQL files from Centauri-Core first
            foreach($sqlFiles as $sqlFile) {
                $path = base_path("CentauriCMS/SQL/" . $sqlFile);
                require_once($path);
            }

            // Loading SQL files from extensions
            $extensionsDirs = Storage::disk("centauri_extensions")->allDirectories();
            $extensionsFiles = Storage::disk("centauri_extensions")->allFiles();

            $extensions = array_merge($extensionsDirs, $extensionsFiles);

            foreach($extensions as $extension) {
                if(!Str::contains($extension, "/")) {
                    $extSQLFiles = Storage::disk("centauri_extensions")->allFiles("/$extension/SQL");
                    
                    foreach($extSQLFiles as $extSQLFile) {
                        $extSQLPath = storage_path("Centauri/Extensions/$extSQLFile");
                        require_once($extSQLPath);
                    }
                }
            }

            return json_encode([
                "type" => "success",
                "title" => "Database updated",
                "description" => "All SQL queries has been successfully executed!"
            ]);
        }
    }
}
