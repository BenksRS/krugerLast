<?php


if ( !function_exists('integration') ) {
    function integration ($connection, $id, $delete = false)
    {
        $manager = app(Modules\Integration\Manager::class);

        return $manager->sync($connection, $id, $delete);
    }
}