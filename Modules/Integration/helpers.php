<?php


if ( !function_exists('integration') ) {
    function integration ()
    {
        return app(Modules\Integration\Manager::class);

/*        return $manager->sync($connection, $id, $delete);*/
    }
}