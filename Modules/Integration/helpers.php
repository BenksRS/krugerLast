<?php

if ( !function_exists('integration') ) {
    function integration (mixed $connection = NULL)
    {
        return new Modules\Integration\Manager($connection);
        /*        return $manager->sync($connection, $id, $delete);*/
    }
}