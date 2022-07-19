<?php

namespace Callkruger\Api\Support\Traits\Relations;

use Callkruger\Api\Models\ApiToken;

trait RelationToken {

    public function token ()
    {
        return $this->morphOne(ApiToken::class, 'tokenable');
    }

}
