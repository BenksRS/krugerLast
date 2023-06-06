<?php

namespace Modules\Alacrity\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed get(string $endpoint, array|null $data = null)
 * @method static mixed post(string $endpoint, array|null $data = null)
 * @method static mixed put(string $endpoint, array|null $data = null)
 * @method static mixed delete(string $endpoint, array|null $data = null)
 */
class AlacrityService extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'alacrity-service';
    }
}
