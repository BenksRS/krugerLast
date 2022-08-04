<?php

namespace Modules\Employees\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\User\Entities\User;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page_info = (object)[
            'title' => 'Employees List',
            'back' => url('employees'),
            'back_title' => 'Employees List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('employees::index', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('employees::create');
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
        $user = User::findOrFail($id);

        $page_info = (object)[
            'title' => 'Employee Information',
            'back' => url('employees'),
            'back_title' => 'Employee List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('employees::livewire.show.show', compact('user','page'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('employees::edit');
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
