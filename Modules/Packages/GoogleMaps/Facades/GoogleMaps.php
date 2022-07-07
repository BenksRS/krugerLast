<?php

namespace Modules\Packages\GoogleMaps\Facades;

use Illuminate\Support\Facades\Facade;
use Modules\Packages\GoogleMaps\Services\DistanceMatrix;

/**
 * @method static DistanceMatrix distanceMatrix()
 * @see \Modules\Packages\GoogleMaps\GoogleMaps
 */
class GoogleMaps extends Facade {

    /**
     * @return string
     */
    protected static function getFacadeAccessor ()
    {
        return 'google-maps';
    }

}