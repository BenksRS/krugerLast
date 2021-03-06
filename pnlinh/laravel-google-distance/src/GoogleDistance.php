<?php

namespace Pnlinh\GoogleDistance;

use Exception;
use GuzzleHttp\Client;
use Pnlinh\GoogleDistance\Contracts\GoogleDistanceContract;

class GoogleDistance implements GoogleDistanceContract
{
    /** @var string */
    private $apiUrl = 'https://maps.googleapis.com/maps/api/distancematrix/json';

    /** @var string */
    private $apiKey;

    /** @var string */
    private $origins;

    /** @var string */
    private $destinations;

    /**
     * GoogleDistance constructor.
     *
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Get API_KEY.
     *
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * Get origins.
     *
     * @return string
     */
    public function getOrigins()
    {
        return $this->origins;
    }

    /**
     * Set origins.
     *
     * @param string $origins
     *
     * @return \Pnlinh\GoogleDistance\GoogleDistance
     */
    public function setOrigins($origins): self
    {
        $this->origins = $origins;

        return $this;
    }

    /**
     * Get destinations.
     *
     * @return string
     */
    public function getDestinations()
    {
        return $this->destinations;
    }

    /**
     * Set destinations.
     *
     * @param string $destinations
     *
     * @return \Pnlinh\GoogleDistance\GoogleDistance
     */
    public function setDestinations($destinations): self
    {
        $this->destinations = $destinations;

        return $this;
    }

    /**
     * Caculate distance from origins to destinations.
     *
     * @param string $origins
     * @param string $destinations
     *
     * @return int
     */
    public function calculate($origins, $destinations): string
    {
        $client = new Client();

        try {
            $response = $client->get($this->apiUrl, [
                'query' => [
                    'units'        => 'imperial',
                    'origins'      => $origins,
                    'travelMode'   => 'DRIVING',
                    'destinations' => $destinations,
                    'key'          => $this->getApiKey(),
                    'random'       => random_int(1, 100),
                ],
            ]);


            $statusCode = $response->getStatusCode();

            if (200 === $statusCode) {
                $responseData = json_decode($response->getBody()->getContents());

//                dd($responseData);
                if (isset($responseData->rows[0]->elements[0]->distance)) {
                    return $responseData->rows[0]->elements[0]->distance->text;
                }
            }

            return 'error';
        } catch (Exception $e) {
            return 'error 2';
        }
    }
}
