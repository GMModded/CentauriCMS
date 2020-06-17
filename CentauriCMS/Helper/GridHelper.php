<?php
namespace Centauri\CMS\Helper;

use Centauri\CMS\Model\Element;

class GridHelper
{
    /**
     * Returns 1-level deep elements from a grid uid.
     * 
     * @param string|int $uid The uid of the grid-element
     * 
     * @return array
     */
    public function findElementsByGridUid($uid, $lid = 1, $grids_sorting_rowpos = null, $grids_sorting_colpos = null)
    {
        return Element::where([
            "grids_parent" => $uid,
            "grids_sorting_rowpos" => $grids_sorting_rowpos,
            "grids_sorting_colpos" => $grids_sorting_colpos,
            "lid" => $lid
        ])->orderBy("sorting", "asc")->get()->all();
    }
}
