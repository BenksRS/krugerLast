<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Routing\Controller;

abstract class AdminController extends Controller {

	public function __construct ()
	{
		$this->middleware('auth:user');
	}

}
