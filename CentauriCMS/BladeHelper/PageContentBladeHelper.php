<?php
namespace Centauri\CMS\BladeHelper;

use Centauri\CMS\Centauri;
use Centauri\CMS\Component\ElementComponent;

/**
 * Renders a page by the given / its uid.
 * 
 * @method action
 * Example:
 *  <div>
 *      My awesome page content from rootpage:
 *      {!! PageContentBladeHelper::render(1) !!}
 *  </div>
 */
class PageContentBladeHelper
{
    /**
     * This will render the given page and return a pure HTML-string back based on the passed uid.
     * 
     * @param string|int $uid The uid of the page which should be rendered.
     * @param string|int $lid The language-id of the current view from client - default 1 - optional.
     * @param string|int $rowPos The rowPos where to fetch elements from the database-table "elements" - optional.
     * @param string|int $colPos The colPos where to fetch elements from the database-table "elements" - optional.
     * 
     * @return string
     */
    public static function render($uid, $lid = 1, $rowPos = 0, $colPos = 0)
    {
        $ElementComponent = Centauri::makeInstance(ElementComponent::class);
        return $ElementComponent->render($uid, 1, 0, 0);
    }
}
