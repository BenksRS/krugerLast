<?php

namespace Modules\Alacrity\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsStatusPivot;

class AlacrityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//        $alacrity=alacrity_service()->post('GetCommentTypeList');//list
        $alacrity=alacrity_service()->post('GetAssignmentSummaryList');//list
//        $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> 2252268]);//FALSE
//        $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> 2289249]);// TRUE
//        $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> 2289252]);// TRUE

        $alacrity=collect($alacrity['AssignmentSummaryList']); //list
//        $alacrity=collect($alacrity['AssignmentDetail']); // details
//
//        $alacrity = $alacrity->where('VendorAcknowledg',true);
        $alacrity=(object)$alacrity;
        dd($alacrity);
        $limit=count($alacrity['CommentList']);

        if($limit > 0){
            $limit=$limit-1;
            $notes = $alacrity['CommentList'][$limit]['CommentString'];
        }else{
            $notes="No Damage loss info in ALACNET!";
        }

        dump($notes);

        return view('alacrity::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function getAll()
    {
        $alacrity=alacrity_service()->post('GetAssignmentSummaryList');

        $alacrity=collect($alacrity['AssignmentSummaryList']);

        $jobs = $alacrity->where('VendorAcknowledg',true);

        foreach ($jobs as $job){
            $this->createJob($job);
        }

        return view('alacrity::index');
    }

    public function acceptJob(){
        $alacrity=alacrity_service()->post('UpdateVendorAcknowledge',['AssignmentId'=> 2289253, 'VendorAccepted'=> True]);

        dump($alacrity);
    }
    public function createJob($job)
    {
        $job=(object)$job;


        $names=explode(' ',$job->HomeOwner);

        $first=$names[0];
        $last=$names[1];

        $today=Carbon::now();
        $lostDate=Carbon::createFromFormat('m/d/Y', $job->LossDate)->format('Y-m-d H:i:s');

        $data=[
            'allacrity_id' => $job->AssignmentId,
            'first_name' => $first,
            'last_name' => $last,
            'street' => $job->LossAddress,
            'city' => $job->LossCity,
            'state' => $job->LossState,
            'zipcode' => $job->LossZipCode,
            'referral_id' => 24,
            'carrier_id' => 583,
            'created_by' => 73,
            'updated_by' => 73,
            'claim_number' => $job->ClaimNumber,
            'email' => $job->HomeOwnerEmail,
            'date_assignment' => $today,
            'date_of_loss' => $lostDate,
            'status_id' => 33,
            'status_collection_id' => 3,
            'billed_by' => null,
        ];

        $created = Assignment::create($data);

        // add job types
        $jobData = Assignment::find($created->id);
        $jobData->job_types()->attach(15);

        // add status open
        AssignmentsStatusPivot::create([
            'assignment_id'=> $created->id,
            'assignment_status_id'=> 33,
            'created_by'=> 73,
        ]);

        // add notes



        $jobData->notes()->create([
            'text'=> $this->notes,
            'notable_id'=> $created->id,
            'created_by'=> 73,
            'notable_type'=>  Assignment::class,
        ]);


        // add phones
        $this->addPhones($created->id);

        if($type == 'next'){
            return redirect()->to('/assignments/new');
        }else{
            return redirect()->to("/assignments/show/$created->id");
        }






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
        return view('alacrity::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('alacrity::edit');
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
