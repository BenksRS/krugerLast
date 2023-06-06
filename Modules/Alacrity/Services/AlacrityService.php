<?php

namespace Modules\Alacrity\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Modules\Alacrity\Entities\AlacritySession;

class AlacrityService
{

    /** 
     * @var mixed
     */
    protected $config;

    /**
     * The base URL for the Alacrity API.
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * The credentials used to authenticate with the Alacrity API.
     *
     * @var array
     */
    protected $credentials;

    /**
     * The authentication data for the Alacrity API.
     *
     * @var array|null
     */
    protected $authData;


    protected $api;
    /**
     * Create a new instance of the AlacrityApiService.
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = Config::get('alacrity');

        $this->baseUrl = $this->config['base_url'];
        $this->credentials = $this->config['credentials'];

        $this->api = Http::withHeaders([
            'Token' => $this->credentials['token'],
        ])->baseUrl($this->baseUrl);
    }

    /**
     * Handle dynamic method calls to the class.
     *
     * @param string $method The name of the method being called.
     * @param array $arguments The arguments being passed to the method.
     * @return mixed The response data.
     * @throws \Exception If the HTTP status code indicates an error.
     */
    public function __call($method, $arguments)
    {
        $response = $this->request($method, $arguments[0], isset($arguments[1]) ? $arguments[1] : []);



        if ($response->failed()) {
            throw new \Exception("Alacrity API error: {$response->status()} - {$response->json('message')}");
        }

        return $response->json();
    }

    /**
     * Handle dynamic static method calls to the class.
     *
     * @param string $method The name of the method being called.
     * @param array $arguments The arguments being passed to the method.
     * @return mixed The response data.
     * @throws \Exception If the HTTP status code indicates an error.
     */
    public static function __callStatic($method, $arguments)
    {
        $instance = new static;

        return $instance->__call($method, $arguments);
    }

    /**
     * Send a request to the specified endpoint.
     *
     * @param string $method The HTTP method to use.
     * @param string $endpoint The endpoint to send the request to.
     * @param array|null $data The data to send with the request.
     * @return mixed The response data.
     */
    public function request($method, $endpoint, $data = [])
    {
        $this->authenticate();

        $headers = [
            'UserSessionId' => $this->authData['user_session_id'] ?? ''
        ];

        $baseData = [
            'UserId' => $this->authData['user_id'] ?? '',
            'appName' => $this->credentials['appName'],
            'version' => $this->credentials['version'],
        ];

        $request = [
            'Request' => array_merge($baseData, $data)
        ];

        $response = $this->api->withHeaders($headers)->{$method}($endpoint, $request);


        return $response;
    }

    /**
     * Authenticate with the Alacrity API and store the authentication data.
     *
     * @return void
     */
    public function authenticate()
    {

        $this->authData = AlacritySession::query()->first();

        if (!$this->authData || strtotime($this->authData['expires_at']) < time()) {

            // No authentication data or expired, make a new request to authenticate
            $response = $this->api->post('SignIn', $this->credentials);

            $userId         = $response->json('UserId');
            $userSessionId  = $response->header('UserSessionId');
            $expiresAt      = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 30 minutes'));

            $this->authData = [
                'user_id' => $userId,
                'user_session_id' => $userSessionId,
                'expires_at' => $expiresAt,
            ];

            // Cache the authentication data for 30 minutes
            AlacritySession::query()->delete();
            AlacritySession::create($this->authData);
        }
    }

    protected function getCacheKeyAuthData()
    {
        return 'alacrity-auth-data-' . md5($this->credentials['appName']);
    }
}
