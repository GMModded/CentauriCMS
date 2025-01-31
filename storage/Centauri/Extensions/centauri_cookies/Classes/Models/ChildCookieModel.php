<?php
namespace Centauri\Extension\Cookie\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChildCookieModel extends Model
{
    /**
     * For soft deletions (using 'deleted_at' column in database table)
     */
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "centauri_cookie_child";

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

    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        "hidden" => 0
    ];

    // /**
    //  * Get the slider item that owns the button.
    //  */
    // public function cookies()
    // {
    //     return $this->belongsTo("\Centauri\Extension\Cookie\Models\ParentCookieModel");
    // }
}
