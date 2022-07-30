<?php

namespace Modules\Integration\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Integration\Repositories\AssignmentRepository;
use Modules\Integration\Repositories\UserRepository;
use Modules\Integration\Services\Firebase\DatabaseService;

class IntegrationController extends Controller {

    public DatabaseService $service;

    public function __construct (DatabaseService $service, UserRepository $repository, AssignmentRepository $assignmentRepository)
    {
        $this->service              = $service;
        $this->repository           = $repository;
        $this->assignmentRepository = $assignmentRepository;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index ()
    {

        integration(['reports'])->get();
/*
        integration(['users', 'workers'])->set();*/

/*        $pictures =  $this->service->reference('pictures')->snapshot()->getValue();

        dump($pictures);*/

/*        integration()->sync('assignments', '31206');*/

        /*        $push = $this->service->reference('users')->push($user->resources());*/

        /*        $users = $this->repository->notSynced()->get();

                foreach ( $users as $user ) {
                    $push = $this->service->reference('users')->push($user->resources());

                    $key = $push->getKey();

                    if ( $key ) {
                        $user->sync()->create(['uuid' => $key]);
                    }
                }*/

        dump('asdasd');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function users (){
        integration(['users','workers'])->set();

    }
    public function gallery (){
        integration(['pictures'])->get();
    }
    public function signature (){
        integration(['signatures'])->get();
    }
    public function jobs (){
        integration(['assignments'])->get();
    }
    public function reports (){
        integration(['reports'])->get();
    }
    public function create ()
    {
        return view('integration::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Renderable
     */
    public function store (Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function show ($id)
    {
        return view('integration::show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function edit ($id)
    {
        return view('integration::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return Renderable
     */
    public function update (Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function destroy ($id)
    {
        //
    }

}
