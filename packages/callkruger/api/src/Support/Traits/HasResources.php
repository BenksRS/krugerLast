<?php

namespace Callkruger\Api\Support\Traits;

trait HasResources {

    public function apiResource ($data)
    {
        return new self::$apiResources['resource']($data);
    }

    public function apiCollecion ($data)
    {
        return new self::$apiResources['collection']($data);
    }

}
