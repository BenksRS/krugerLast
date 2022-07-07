<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class CoreController extends AdminController
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return redirect('/dashboard/list/open');
    }
}
