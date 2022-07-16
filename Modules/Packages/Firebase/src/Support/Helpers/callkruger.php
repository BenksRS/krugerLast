<?php

use Callkruger\Api\Support\Collections\ApiCollection;

if ( !function_exists('callkruger') ) {
    function callkruger ($collection = NULL)
    {
        return new ApiCollection($collection);
    }
}

if ( !function_exists('new_instance') ) {
    function new_instance ($class, $attr = [])
    {
        try {
            $class = new \ReflectionClass($class);

            return $class->newInstance($attr);
        } catch ( ReflectionException $e ) {
            echo $e->getMessage();
        }

        return NULL;
    }
}
