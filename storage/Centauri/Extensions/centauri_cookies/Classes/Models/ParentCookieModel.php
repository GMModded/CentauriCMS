<?php
namespace Centauri\Extension\Cookie\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParentCookieModel extends Model
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
    protected $table = "centauri_cookie_parent";

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

    /**
     * Getter for the child cookies of this parent cookie item.
     * 
     * @return array|void
     */
    public function getChildCookies()
    {
        return
            $this->hasMany(
                ChildCookieModel::class,
                "parent_uid",
                "uid"
            )
            ->where("hidden", 0)
            ->orderBy("sorting", "asc")
            ->get()
        ->all();

        // return ChildCookieModel::where([
        //     "hidden" => 0,
        //     "parent_uid" => $this->getAttribute("uid")
        // ])->get()->all();
    }
}
