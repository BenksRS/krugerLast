<?php

if ( !function_exists('integration') ) {
    function integration (mixed $connection = NULL)
    {
        return new Modules\Integration\Manager($connection);
        /*        return $manager->sync($connection, $id, $delete);*/
    }
}

if ( !function_exists('integration_morphs') ) {
    function integration_morphs ()
    {
        $config = config('integration');

        $prefix      = data_get($config, 'prefix', 'sync.');
        $connections = data_get($config, 'connection');

        return collect($connections)
            ->where('queues.set', TRUE)
            ->flatMap(fn ($item, $key) => [$key => $item['model']])
            ->filter()->all();
    }
}