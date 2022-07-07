<?php

namespace Modules\Packages\GoogleMaps\Concerns;

trait HasServiceParameters {

    protected $data;

    protected function setParamByKey ($key, $value)
    {
        $data = $this->hydrateParam($value);

        $this->data[$key] = array_merge($this->data[$key] ?? [], $data);
    }

    protected function hydrateParam ($value)
    {
        if ( $value ) {
            $value = collect($value)->map(function ($item) {
                if ( !is_array($item) ) {
                    $item = str_contains($item, '|') ? explode('|', $item) : [$item];
                }

                return $item;
            })->collapse()->all();
        }

        return $value;
    }

}