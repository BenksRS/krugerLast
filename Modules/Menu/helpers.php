<?php

if ( !function_exists('get_menu') ) {
    function get_menu ()
    {
        return \Modules\Menu\Facades\Menu::make();
    }
}