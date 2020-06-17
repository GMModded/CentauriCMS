<?php
namespace Centauri\CMS\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = "be_roles";

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
    ];

    /**
     * Getter for of the buttons of this slider item.
     * 
     * @return array|void
     */
    public function getPermissions()
    {
        return
            $this->hasMany(
                \Centauri\CMS\Model\Permission::class,
                "parent_uid",
                "uid"
            )
            ->get()
            ->all()
        ;
    }
}
