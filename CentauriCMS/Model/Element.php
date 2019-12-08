<?php
namespace Centauri\CMS\Model;

use Illuminate\Database\Eloquent\Model;

class Element extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "elements";

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = "uid";

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    const CREATED_AT = "creation_date";
    const UPDATED_AT = "last_update";

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        "pid" => 0,
        "lid" => 0,
        "data" => "",
        "colPos" => 0
    ];
}
