<?php
namespace Centauri\Extension\Frontend\Model;

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
    protected $table = "centauri_frontend_slideritems";

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
     * 
     * @return array|void
     */
    public function getButtons()
    {
        return $this->hasMany(
            \Centauri\Extension\Frontend\Model\SliderItemButtonModel::class,
            "parent_uid",
            "uid"
        )

        ->where([
            "hidden" => 0
        ])

        ->orderBy("sorting", "asc")->get()->all();
    }
}
