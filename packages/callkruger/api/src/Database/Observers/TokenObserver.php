<?php

namespace Callkruger\Api\Database\Observers;

use Callkruger\Api\Models\ApiDevice;
use Callkruger\Api\Models\ApiToken;

class TokenObserver {

    public function updated (ApiToken $token)
    {
        $this->saveDevice($token);
    }

    protected function saveDevice (ApiToken $token)
    {
        $deviceToken = request()->device_token;

        if ( !empty($deviceToken) ) {

            ApiDevice::firstOrCreate(
                ['token' => $deviceToken]
            )->connections()->firstOrCreate(
                ['token_id' => $token->id]
            );
        }
    }

}
