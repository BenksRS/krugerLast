<?php

namespace Modules\Scheduling\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Timeline extends Facade {

	protected static function getFacadeAccessor ()
	{
		return 'scheduling.timeline';
	}

}