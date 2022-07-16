<?php

namespace Callkruger\Api\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ApiResource extends JsonResource {

    protected static $attributes;

    public static function custom ($resource, array $attributes)
    {
        self::$attributes = $attributes;

        $parameters = collect([])->wrap($resource)->toArray();

        return collect((new static($parameters))->collection($parameters)->jsonSerialize());
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray ($request)
    {
        return self::$attributes ? $this->customAttributes() : $this->resource->toArray();
    }

    protected function customAttributes ()
    {
        $resource   = $this->resource;
        $attributes = collect(Arr::dot(self::$attributes));

        $data = $attributes->map(function ($attribute) use ($resource) {
            $col = $resource[$attribute] ?? NULL;

            return is_string($col) ? trim($col) : $col;
        })->all();

        return undot($data);
    }

}
