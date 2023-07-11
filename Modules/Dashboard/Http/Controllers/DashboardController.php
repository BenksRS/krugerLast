<?php

namespace Modules\Dashboard\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Core\Http\Controllers\AdminController;
use Auth;


class DashboardController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $userLogged = Auth::user();

        if($userLogged->group_id == 2){
            return redirect('/profile/app');
        }
        return redirect('/dashboard/list/open');
        
    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function list($type){

        $page_info = (object)[
            'title' => "List $type jobs",
            'back' => url('dashboard'),
            'back_title' => 'Dashboard'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('dashboard::list', compact('page', 'type'));

    }
    public function create()
    {
        return view('dashboard::create');
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
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('dashboard::edit');
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
