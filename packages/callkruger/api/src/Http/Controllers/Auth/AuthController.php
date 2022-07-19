<?php

namespace Callkruger\Api\Http\Controllers\Auth;

use Callkruger\Api\Http\Controllers\Controller;
use Callkruger\Api\Http\Requests\AuthRequest;
use Callkruger\Api\Http\Resources\Account\AccountResource;
use Callkruger\Api\Manager;

class AuthController extends Controller {

    public function token (AuthRequest $request, Manager $manager)
    {
        $credentials = $request->only(['username', 'password']);

        $auth  = $manager->auth($credentials);
        $auth->token();

        return (new AccountResource($auth->user()))->jsonSerialize();
    }

}
