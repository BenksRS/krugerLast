<?php

namespace Modules\Packages\GoogleMaps\Services;

use Modules\Packages\GoogleMaps\Entities\Direction;
use Modules\Packages\GoogleMaps\WebService;

class DistanceMatrix extends WebService {

    /**
     * @param mixed ...$parameters
     *
     * @return $this
     */
    public function addOrigin (...$parameters)
    {
        $this->setResourceData('origins', $parameters);

        return $this;
    }

    /**
     * @param mixed ...$parameters
     *
     * @return $this
     */
    public function addDestination (...$parameters)
    {
        $this->setResourceData('destinations', $parameters);

        return $this;
    }

    public function resolve ()
    {
        $directions = Direction::whereIn('origin_desc', $this->resource['origins'])
                               ->whereIn('destination_desc', $this->resource['destinations'])->get();
        dump($directions);
    }

}