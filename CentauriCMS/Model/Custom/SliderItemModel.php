<?php
namespace Centauri\CMS\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SliderItemModel extends Model
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
    protected $table = "slideritems";

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "parent_uid",
        "sorting",
        "image",
        "title",
        "teasertext",
        "buttons"
    ];

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
        "title" => "",
        "teasertext" => "",
    ];

    /**
     * Getter for of the buttons of this slider item.
     */
    public function buttons()
    {
        return $this->hasMany(\Centauri\CMS\Model\SliderItemButtonModel::class, "parent_uid", "uid")->get()->all();
    }
}
