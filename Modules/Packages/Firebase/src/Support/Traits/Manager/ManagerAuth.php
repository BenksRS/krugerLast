<?php

namespace Callkruger\Api\Support\Traits\Manager;

use Illuminate\Support\Facades\Hash;

trait ManagerAuth {

    protected $user;

    public function auth ($credentials)
    {
        $this->model = app($this->provider['model']);

        $username = $this->provider['fields']['username'];
        $password = $this->provider['fields']['password'];

        $user = $this->model->where([
            $username => $credentials['username']
        ])->first();

        if ( !$user || !Hash::check($credentials['password'], $user[$password]) ) {
            api_response(401, 'These credentials do not match our records.');
        }
        $this->user = $user;

        return $this;
    }

    public function user ()
    {
        return $this->user;
    }

    public function token ()
    {
        if ( !$this->user ) {
            api_response(401, 'Unauthorized.');
        }
        $payload = [
            'uid'  => $this->user['id'],
            'user' => $this->user[$this->provider['fields']['username']],
        ];

        $token = $this->user->token()->firstOrCreate([], ['token' => api_token($payload)]);
        $token->increment('request');

        return $token;
    }

}
