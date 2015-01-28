<?php
use Nerweb\Tblist\BaseTblist as NerwebBaseTblist;

/**
 * Laravel Tblist
 * http://github.com/nerweb93/laravel-tblist
 *
 * Class BaseTblist
 * @package Tblist
 */
abstract class BaseTblist extends NerwebBaseTblist {

    // sometimes we want to start at page 2 (default page 1, of course)
    // public $page = 1;

    // Set Columns for sortable and action

    function __construct()
    {
        // set per page drop down selection (default '1,5,10,25,50,100,250')
        // accepts string separated by comma of item
        // you can insert 'all' string without quotes to select all item.
        $this->perPageSelection    = '1,5,10,25,50,100,250';

        // set per page, the number of item we need to show in each page (default 25)
        $this->perPage             = 25;

        // pagination will jump into from current page.
        $this->pageJump            = 10;
    }

    /**
     * Get pagination info
     *
     * @return string
     */
    public function getPaginationInfo()
    {
        $markup  = "<div class=\"pagination-info\">";
        $markup .= "Showing {$this->page} to {$this->lastPage} of {$this->totalCount} entries";
        $markup .= "</div>";

        return $markup;
    }
}
