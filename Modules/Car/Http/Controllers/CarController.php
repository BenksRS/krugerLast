<?php

namespace Modules\Car\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Auth;
use Illuminate\Support\Facades\Route;
use Modules\Car\Entities\Car;


class CarController extends Controller
{
    public function __construct ()
    {
        $this->middleware('auth:user');
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $page_info = (object)[
            'title' => 'Cars',
            'back' => url('cars'),
            'back_title' => 'List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('car::index', compact('page'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('car::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {

        $car = Car::find($id);
        $url =  Route::getCurrentRoute()->uri();

        $page_info = (object)[
            'title' => 'Car Information',
            'back' => url('cars'),
            'back_title' => 'Cars List'
        ];
        \session()->flash('page',$page_info);
        \session()->put('url', $url);
        $page =\session()->get('page');

        return view('car::livewire.list.show', compact('car','page'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('car::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
