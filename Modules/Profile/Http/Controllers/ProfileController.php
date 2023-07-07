<?php

namespace Modules\Profile\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Modules\User\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Support\Renderable;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:user');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $userLogged = Auth::user();

        $user = User::findOrFail($userLogged->id);
        $url =  Route::getCurrentRoute()->uri();

        $page = (object)[
            'title' => 'Employee Information',
            'back' => url('#'),
            'back_title' => 'Employee List'
        ];

        \session()->flash('page', $page);
        \session()->put('url', $url);


        return view('profile::index', compact('page', 'user'));
    }
}
