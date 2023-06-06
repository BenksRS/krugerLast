<?php

use Modules\Alacrity\Services\AlacrityService;

if (!function_exists('alacrity_service')) {

    /**
     * @return AlacrityService
     */
    function alacrity_service()
    {
        return new alacrityService();
    }
}
