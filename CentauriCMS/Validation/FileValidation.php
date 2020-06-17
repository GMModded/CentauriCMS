<?php
namespace Centauri\CMS\Validation;

use Illuminate\Support\Str;

class FileValidation
{
    public static function validate($data)
    {
        $field = $data["field"];
        $value = $data["value"];

        $CCE_FIELD = $data["CCE_FIELD"];
        $config = $CCE_FIELD["config"];

        $state = true;
        $result = null;

        if(isset($config["required"])) {
            if($config["required"]) {
                if(is_null($value)) {
                    $state = false;

                    $result = json_encode([
                        "type" => "error",
                        "title" => "File-Validation",
                        "description" => "No file has been selected - a file is required in order to save this record."
                    ]);
                } else {
                    if(Str::contains($value, ",")) {
                        if(isset($config["minItems"])) {
                            $value = explode(",", $value);

                            if(sizeof($value) < $config["minItems"]) {
                                $files = " file is";
                                if($config["minItems"] > 1) {
                                    $files = " files are";
                                }

                                $state = false;

                                $result = json_encode([
                                    "type" => "error",
                                    "title" => "File-Validation",
                                    "description" => "Minimum of " . $config["minItems"] . $files . " required - only " . sizeof($value) . " found for field '" . ucfirst($field) ."'"
                                ]);
                            }
                        }

                        if(isset($config["maxItems"])) {
                            if(sizeof($value) > $config["maxItems"]) {
                                $files = " file is";
                                if($config["maxItems"] < 1) {
                                    $files = " files are";
                                }

                                $state = false;

                                $result = json_encode([
                                    "type" => "error",
                                    "title" => "File-Validation",
                                    "description" => "Maximum of " . $config["maxItems"] . $files . " allowed for field '" . ucfirst($field) . "'"
                                ]);
                            }
                        }
                    } else {
                        if(isset($config["minItems"])) {
                            if($config["minItems"] > 1) {
                                $state = false;

                                $result = json_encode([
                                    "type" => "error",
                                    "title" => "File-Validation",
                                    "description" => "Minimum of " . $config["minItems"] . " FILES" . " required - only 1 found"
                                ]);
                            }
                        }
                    }
                }
            }
        }

        return [
            "state" => $state,
            "result" => $result
        ];
    }
}
