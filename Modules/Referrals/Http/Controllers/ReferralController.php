<?php

namespace Modules\Referrals\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Http\Controllers\AdminController;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorization;
use Modules\Referrals\Entities\ReferralAuthorizationPivot;
use Modules\Referrals\Entities\ReferralType;
use MongoDB\Driver\Session;

class ReferralController extends AdminController
{

    public function __construct ()
    {
        $this->middleware('auth:user');
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page_info = (object)[
            'title' => 'Referrals All',
            'back' => url('referrals'),
            'back_title' => 'Referral List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::index', compact('page'));
    }

    public function inactive()
    {
        $page_info = (object)[
            'title' => 'Referrals Inactive',
            'back' => url('inactive'),
            'back_title' => 'Referral Inactive List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::inactive', compact('page'));
    }

    public function myinactive()
    {
        $page_info = (object)[
            'title' => 'My Referrals Inactive',
            'back' => url('myinactive'),
            'back_title' => 'My Referral Inactive List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::myinactive', compact('page'));
    }

    public function mylist()
    {
        $page_info = (object)[
            'title' => 'Referrals My list',
            'back' => url('referrals/mylist'),
            'back_title' => 'Referral My List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::mylist', compact('page'));
    }
    public function new ()
    {
        $page_info = (object)[
            'title' => 'New Referral',
            'back' => url('referrals'),
            'back_title' => 'Referral List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::new', compact('page'));

    }

    public function new_prospect()
    {

        $page_info = (object)[
            'title' => 'New Prospect',
            'back' => url('Prospect'),
            'back_title' => 'Prospect List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('referrals::new_prospect', compact('page'));

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('referrals::create');
    }

    /**
     *
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    public function valid_address($id){
        $referral = Referral::findOrFail($id);
    }


    public function bloco_update(Request $request){

        $form = [];
        parse_str($request->form,$form);
        $toaster=false;
        $referral = Referral::findOrFail($request->id);

        $control = $request->action;
        $area = $request->action;
        $view=$request->view;
        $types=ReferralType::all();

            if($control == 'UPDATE'){
                // save
                $update= $referral->update($form);

                $toaster=TRUE;
                if($update){
                    toastr()->success("Referral #$request->id updated!");
                }else{
                    toastr()->error("Fail !!! on update referral #$request->id.");
                }
            }
        return  view($view, compact('referral','control','types', 'toaster'));

    }
    public function ref_auth_sync(Request $request){

        $referral= Referral::findOrFail($request->referral_id);
        $auths = $referral->authorizathions();


        if ($request->action == 'remove'){
            $auths->detach($request->id);
        }else{
            $auths->attach($request->id);
        }

        return  view('referrals::show.tabs.auth.auth_list', compact('referral'));
    }

    public function show($id)
    {

        $referral = Referral::findOrFail($id);

        $page_info = (object)[
            'title' => 'Referral Information',
            'back' => url('referrals'),
            'back_title' => 'Referrals List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');


        return view('referrals::show', compact('referral','page'));

    }

    public function show_prospect($id)
    {

        $referral = Referral::findOrFail($id);

        $page_info = (object)[
            'title' => 'Prospect Information',
            'back' => url('/referrals/prospects/'),
            'back_title' => 'Prospect List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');


        return view('referrals::show', compact('referral','page'));

    }

    public function prospect_list()
    {

        $page_info = (object)[
            'title' => 'Prospect List',
            'back' => url('/referrals/prospects/'),
            'back_title' => 'Prospect List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');


        return view('referrals::prospect_list_all', compact('page'));

    }
    public function prospect_my_list()
    {

        $page_info = (object)[
            'title' => 'Prospect My List',
            'back' => url('/referrals/prospects/'),
            'back_title' => 'Prospect My List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');


        return view('referrals::prospect_my_list', compact('page'));

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
    public function testlive(Request $request){
        return view('referrals::testlive');
    }
    public function test(Request $request)
    {
        $return = $request->company_entity;
        return $return;
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
