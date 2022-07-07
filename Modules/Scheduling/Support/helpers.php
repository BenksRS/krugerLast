<?php

if ( !function_exists('_timeline') ) {
    function _timeline ($key)
    {
        return data_get(config('scheduling.timeline'), $key);
    }
}