<?php

namespace Modules\Referrals\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\AdminController;
use Modules\Referrals\Entities\ReferralAuthorization;

class AuthorizationController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page_info = (object)[
            'title' => 'Authorizathion List',
            'back' => url('/referrals/authorizations'),
            'back_title' => 'Authorizathion List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::auth_list', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

    }
    public function auth_new ()
    {
        $page_info = (object)[
            'title' => 'New Authorizathion',
            'back' => url('/referrals/authorizations'),
            'back_title' => 'Authorizathion List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::auth_new', compact('page'));

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
        $page_info = (object)[
            'title' => 'Edit Authorizathion',
            'back' => url('/referrals/authorizations'),
            'back_title' => 'Authorizathion List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');
        $auth=(object)[
            'id' =>$id
        ];

        return view('referrals::auth_show', compact('page','auth'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('referrals::edit');
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
