<?php

namespace Modules\Referrals\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\AdminController;
use Modules\Referrals\Entities\ReferralType;

class TypeController extends AdminController
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        echo "<h2>Categories:</h2>";
        foreach ( ReferralType::all() as $category) {
            $url=route('referrals.types.show', ['id' => $category->id]);


            echo "<h3><a href={$url}>#{$category->id}</a> {$category->name} </h3> ";

        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

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
        $category = ReferralType::find($id);
        $back=route('referrals.types.index');
//            dd($category);
        echo "<h2>Categoria: #{$category->id}  <a href='{$back}'> << back</a></h2>";
        echo "<p>Name: {$category->name} </p>";


        $referrals=$category->referrals()->get();

        if($referrals){

            echo "<h2>Referrals:</h2>";
            foreach ($referrals as $referral){
                echo "<p>{$referral->company_entity} ( {$referral->company_fictitions} ) </p>";
            }
        }
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
