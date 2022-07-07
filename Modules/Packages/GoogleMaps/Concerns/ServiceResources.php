<?php

namespace Modules\Packages\GoogleMaps\Concerns;

trait ServiceResources {

    protected $resource;

    protected function setResourceData ($index, $value)
    {
        $value                  = $this->buildResourceData($value)->all();
        $this->resource[$index] = array_merge($this->resource[$index] ?? [], $value);
    }

    protected function buildQuery ()
    {
        $collection = collect($this->resource)->map(function ($item) {
            return $this->buildResourceData($item)->implode('|');
        })->all();

        dump($collection);

        $this->service['resource']['key'] = $this->apiKey;
        $this->service['resource']        = array_merge($this->service['resource'] ?? [], $collection);
    }

    protected function buildResourceData ($item)
    {
        return collect($item)->map(function ($values) {

            if ( is_array($values) ) {
                return $values;
            }

            return str_contains($values, '|') ? explode('|', $values) : $values;
        })->flatten();
    }

}