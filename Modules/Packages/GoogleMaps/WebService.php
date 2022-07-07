<?php

namespace Modules\Packages\GoogleMaps;

use Illuminate\Support\Facades\Http;
use Modules\Packages\GoogleMaps\Concerns\ServiceResources;

abstract class WebService {

    use ServiceResources;

    protected $service;

    /**
     * @var string
     */
    protected $apiKey;

    /**
     * The resource instance.
     *
     * @var mixed
     */
    protected $response;

    /**
     * The mapped collection instance.
     *
     * @var \Illuminate\Support\Collection
     */
    public $collection;

    /**
     * @param string $apiKey
     * @param string $service
     */
    public function __construct (string $apiKey, $service)
    {
        $this->apiKey  = $apiKey;
        $this->service = $service;
    }

    public function request ()
    {
        $this->buildQuery();

        $response = Http::get($this->service['endpoint'], $this->service['resource']);

        if ( $response->status() === 200 ) {
            $this->response   = $response->json();
            $this->collection = $response->collect();
        }

        $origins      = $this->response['origin_addresses'];
        $destinations = $this->response['destination_addresses'];
        $rows         = $this->response['rows'];

        $data = [];

        foreach ( $origins as $i => $origin ) {

            $elements = $rows[$i]['elements'];
            foreach ( $elements as $j => $element ) {

                $data[$i][$j]['origin_id']   = $i;
                $data[$i][$j]['origin_desc'] = $origins[$i];

                $data[$i][$j]['destination_id']   = $j;
                $data[$i][$j]['destination_desc'] = $destinations[$j];

                $data[$i][$j]['distance_text']  = $element['distance']['text'];
                $data[$i][$j]['distance_value'] = $element['distance']['value'];

                $data[$i][$j]['duration_text']  = $element['duration']['text'];
                $data[$i][$j]['duration_value'] = $element['duration']['value'];
            }
        }

        return $data;
    }

    protected function test ()
    {
        $array = [
            'destination_addresses' => [
                0 => 'Hercules St, Santa Clarita, CA 91355, USA',
                1 => '13014 Ash Ln, St Amant, LA 70774, USA',
            ],
            'origin_addresses'      => [
                0 => '28800 LA-444, Springfield, LA 70462, USA',
                1 => '42117 Red Maple St, Hammond, LA 70403, USA',
            ],
            'rows'                  => [
                0 => [
                    'elements' => [
                        0 => [
                            'distance' => [
                                'text'  => '1,895 mi',
                                'value' => 3048936,
                            ],
                            'duration' => [
                                'text'  => '1 day 4 hours',
                                'value' => 100236,
                            ],
                            'status'   => 'OK',
                        ],
                        1 => [
                            'distance' => [
                                'text'  => '26.6 mi',
                                'value' => 42876,
                            ],
                            'duration' => [
                                'text'  => '32 mins',
                                'value' => 1942,
                            ],
                            'status'   => 'OK',
                        ],
                    ],
                ],
                1 => [
                    'elements' => [
                        0 => [
                            'distance' => [
                                'text'  => '1,894 mi',
                                'value' => 3048188,
                            ],
                            'duration' => [
                                'text'  => '1 day 4 hours',
                                'value' => 100078,
                            ],
                            'status'   => 'OK',
                        ],
                        1 => [
                            'distance' => [
                                'text'  => '38.7 mi',
                                'value' => 62293,
                            ],
                            'duration' => [
                                'text'  => '48 mins',
                                'value' => 2880,
                            ],
                            'status'   => 'OK',
                        ],
                    ],
                ],
            ],
            'status'                => 'OK',
        ];

        $origins      = $array['origin_addresses'];
        $destinations = $array['destination_addresses'];
        $rows         = $array['rows'];

        $data = [];

        foreach ( $origins as $i => $origin ) {

            $elements = $rows[$i]['elements'];
            foreach ( $elements as $j => $element ) {

                $data[$i][$j]['origin_id']   = $i;
                $data[$i][$j]['origin_desc'] = $origins[$i];

                $data[$i][$j]['destination_id']   = $j;
                $data[$i][$j]['destination_desc'] = $destinations[$j];

                $data[$i][$j]['distance_text']  = $element['distance']['text'];
                $data[$i][$j]['distance_value'] = $element['distance']['value'];

                $data[$i][$j]['duration_text']  = $element['duration']['text'];
                $data[$i][$j]['duration_value'] = $element['duration']['value'];
            }
        }
    }

}