<?php

namespace Modules\Alacrity\Services;

use Illuminate\Support\Carbon;
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
     * @var array
     */
    public $authData;


    public $api;
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

        $this->api = Http::withoutVerifying()->withHeaders([
            'Token' => $this->credentials['token'],
        ])->withOptions(["verify" => false])->baseUrl($this->baseUrl);
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

        $response = $this->request($method, $arguments[0], isset($arguments[1]) ? $arguments[1] : [], isset($arguments[2]) ? $arguments[2] : []);

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
     * @param array|null $additionalData Any additional data to send with the request.
     * @return mixed The response data.
     */
    public function request($method, $endpoint, $data = [], $additionalData = [])
    {

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

        $request = array_merge($request, $additionalData);

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
        // $this->authData = AlacritySession::first();

        // Retrieve the first instance of the AlacritySession model from the database
        $session = AlacritySession::first();


        // Check if the session does not exist or if it has expired
        if (!$session || $this->isSessionExpired($session)) {
            // Create a new session if it doesn't exist or if it has expired
            $response = $this->api->post('SignIn', $this->credentials);
            $session = $this->createSessionIfNotExists($response);
        } else {
            $this->authData = $session;
        }



        // No authentication data or expired, make a new request to authenticate
        /*         $response = $this->api->post('SignIn', $this->credentials);

        $userId         = $response->json('UserId');
        $userSessionId  = $response->header('UserSessionId');
        $expiresAt      = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 30 minutes'));

        $this->authData = [
            'user_id' => $userId,
            'user_session_id' => $userSessionId,
            'expires_at' => $expiresAt,
        ];

        if ($userId) {
            // Cache the authentication data for 30 minutes
            AlacritySession::query()->delete();
            AlacritySession::create($this->authData);
        } */
    }



    private function isSessionExpired($session)
    {
        $expirationDate = Carbon::parse($session->expires_at);
        return $expirationDate->isPast();
    }

    /**
     * Creates a new session.
     *
     * @return AlacritySession The newly created session.
     */
    private function createSessionIfNotExists($response)
    {
        $lifetime = $this->config['session_lifetime'];

        $this->authData = [
            'user_id' => $response->json('UserId'),
            'user_session_id' => $response->header('UserSessionId'),
            'expires_at' => Carbon::now()->addMinutes($lifetime),
        ];

        AlacritySession::query()->delete();
        AlacritySession::create($this->authData);
    }

    protected function getCacheKeyAuthData()
    {
        return 'alacrity-auth-data-' . md5($this->credentials['appName']);
    }
}
