<?php

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

if ( !function_exists('api_response') ) {
    function api_response ($code = 200, $message = NULL, $attributes = [])
    {
        $response = response()->json(collect([
            'code'    => $code,
            'message' => $message,
        ])->merge($attributes)->filter()->all(), $code);

        throw new HttpResponseException($response);
    }
}
if ( !function_exists('api_token') ) {
    function api_token ($payload)
    {
        return Crypt::encryptString(base64_encode(json_encode($payload)));
    }
}

if ( !function_exists('api_provider') ) {
    function api_provider ($name)
    {
        $config  = config('callkruger-api.providers');
        $collect = collect($config);

        $model = $collect->get($name);

        if ( !$name || empty($model) ) {
            return NULL;
        }

        return $model;
    }
}

if ( !function_exists('api_connections') ) {
    function api_connections ($provider, $connection = 'local', $actions = FALSE)
    {
        $key = 'connections.' . $connection;
        $key = $actions ? $key . '.actions' : $key;

        return data_get($provider, $key);
    }
}

if ( !function_exists('api_table') ) {
    function api_table ($name, $connection = 'default')
    {
        $config  = config('callkruger-api.table_names');
        $collect = collect($config);

        $tables = $collect->get($name);

        if ( !$name || empty($tables) ) {
            return NULL;
        }

        return $tables[$connection];
    }
}

if ( !function_exists('class_name') ) {
    function class_name ($class)
    {
        $reflection = new ReflectionClass($class);

        return Str::kebab(class_basename($reflection->getName()));
    }
}

if ( !function_exists('undot') ) {
    function undot ($dotted)
    {
        $array = [];
        foreach ( $dotted as $key => $value ) {
            data_set($array, $key, $value);
        }

        return $array;
    }
}
