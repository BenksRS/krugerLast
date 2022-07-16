<?php

if ( !function_exists('sync_data') ) {
    function sync_data ($provider = NULL, $uid = NULL, $delete = FALSE)
    {
        $app = app();
        (new Callkruger\Api\Manager($app))->sync($provider, $uid, $delete);
    }
}
