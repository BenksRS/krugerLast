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
    }


    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $referrals= Referral::all();
        return view('referrals::index', compact('referrals'));

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

//
//
//
//
//        if($referral){
//            $back=route('referrals.index');
//
//            echo "<h2>REFERRAL: #{$referral->id}  <a href='{$back}'> << back</a></h2>";
//            echo "<p>Name: {$referral->company_entity} ( {$referral->company_fictitions} ) </p>";
//            echo "<p>ADDRESS: {$referral->street}, {$referral->city}, {$referral->state} - {$referral->zipcode}</p>";
//
//
//            $type=$referral->type;
//            if($type){
//                echo "<h2>Type:</h2>";
//                echo "<p>{$type->name} </p>";
//            }
//            $carriers=$referral->carriers;
//
//            if($carriers){
//
//                echo "<h2>Carriers:</h2>";
//                foreach ($carriers as $carrier){
//                    echo "<p>{$carrier->company_entity} ( {$carrier->company_fictitions} ) </p>";
//                }
//            }
//
//            $phones=$referral->phones;
//
//            if($phones->isNotEmpty()){
//                echo "<h2>Phones:</h2>";
//                foreach ($phones as $phone){
//                    echo "<p>{$phone->contact} - {$phone->phone} ({$phone->preferred})</p>";
//                }
//            }
//
//            $authorizathions=$referral->authorizathions;
//
//            if($authorizathions){
////                dd($authorizations);
//                echo "<h2>Authorizations:</h2>";
//                foreach ($authorizathions as $authorization){
//                    echo "<p>{$authorization->name}  ({$authorization->b64})</p>";
//                }
//            }
//
//
////            $notes = $referral->notes;
////            if ( $notes ) {
////                //                dd($authorizations);
////                echo "<h2>Notes:</h2>";
////                foreach ( $notes as $note ) {
////                    echo "<p> {$note->text} - ( by {$note->user->name} at {$note->created_at} )</p>";
////                }
////            }
//
//
//        }
//
//
//
////        return view('referrals::show');
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
