<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Auth;

class CoreController extends AdminController
{

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $userLogged = Auth::user();

        if ($userLogged->group_id == 2) {
            return redirect('/profile/app');
        }
        return redirect('/dashboard/list/open');
    }
}
