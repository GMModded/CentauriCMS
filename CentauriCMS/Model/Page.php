<?php
namespace Centauri\CMS\Model;

use Centauri\CMS\Utility\DomainsUtility;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
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
    protected $table = "pages";

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
        "pid" => 1,
        "lid" => 1,
        "hidden" => 0,
        "backend_layout" => "",

        "seo_keywords" => "",
        "seo_description" => ""
    ];

    /**
     * Getter for of the buttons of this slider item.
     * 
     * @return array|void
     */
    public function getDomain()
    {
        if($this->page_type == "rootpage") {
            $host = $this->slugs;

            if($host == "/") {
                $host = $_SERVER["HTTP_HOST"];
            }

            $file = DomainsUtility::getDomainFileByHost($host);
            return DomainsUtility::getConfigByDomainFile($file);
        }

        return null;
    }
}
