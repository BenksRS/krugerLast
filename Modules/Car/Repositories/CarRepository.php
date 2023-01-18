<?php

namespace Modules\Car\Repositories;

use Carbon\Carbon;
use Modules\Car\Entities\Car;
use Modules\Car\Scopes\CarScope;

class CarRepository extends Car{

    use CarScope;
    public function __construct ()
    {
        parent::__construct();
    }



}
