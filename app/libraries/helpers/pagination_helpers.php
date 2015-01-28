<?php

// META HELPER

function input_get_perpage_offset()
{

    // Set $page

    $page       = \Input::get('page');
    if ( ! is_numeric($page) )
    {
        $page = 1;
    }

    if (((int) $page) < 1)
    {
        $page = 1;
    }

    // Set $per_page

    $per_page   = \Input::get('per_page');
    if ( ! is_numeric($per_page))
    {
        $per_page = 1;
    }

    if (((int) $per_page) < 1)
    {
        $per_page = 1;
    }


    $offset = ($page - 1) * $per_page;

    return array(
        $per_page,   // per_page
        $offset,    // Offset
        $page,      // Page
    );
}