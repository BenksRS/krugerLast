<?php

namespace Modules\Alacrity\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Alacrity\Entities\AlacrityJobs;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsPhones;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Gdrive\Entities\QueeDir;
use Modules\Gdrive\Entities\QueeFiles;

class AlacrityController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
//
//        $alacrity=alacrity_service()->post('UpdateJobProgress', ['AssignmentId'=> 2289259], ['JobProgress' => 25]);
//
//dd($alacrity);
//        send_wpp('foi!!! @14079896366','tech',"14079896366");


//        $alacrity=alacrity_service()->post('GetCommentTypeList');//list
//        $alacrity=alacrity_service()->post('GetAssignmentSummaryList');//list
        $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> 2289261]);//FALSE
//        $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> 2289249]);// TRUE
//        $alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> 2289252]);// TRUE

//        $alacrity=collect($alacrity['AssignmentSummaryList']); //list
        $alacrity=collect($alacrity['AssignmentDetail']); // details
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
            $this->add_queue_alecrity($job);
        }
    }

    public function add_queue_alecrity($job){
            $job=(object)$job;

            $queue=AlacrityJobs::where('alacrity_id',$job->AssignmentId)->first();

            if(!isset($queue)){
                $now=Carbon::now();
                $history= "<b># Added to queue</b> - $now";
                AlacrityJobs::create([
                    'order' =>50,
                    'alacrity_id' =>$job->AssignmentId,
                    'status' =>'pending',
                    'history' =>$history
                ])->save();
            }

    }

    public function queue_jobs()
    {
        $queue=AlacrityJobs::whereIn('status',['pending', 'processing'])->orderBy('order')->first();
        if(isset($queue)){
            if($queue->status == 'pending'){
                // start creating dir
                $this->createJob($queue->alacrity_id);
            }
        }


    }
    public function updateHistoryFiles($id, $etapa){
        $now=Carbon::now();
        $QueueDir = AlacrityJobs::where('alacrity_id', $id)->first();
        $message="<b>$etapa:</b> $now";
        $message="$QueueDir->history<br>$message";

        $update=[
            'history' => $message
        ];
        $QueueDir->update($update);
    }

    public function acceptJob($jobId){

        try {
            $alacrity=alacrity_service()->post('UpdateVendorAcknowledge',['AssignmentId'=> $jobId], ['VendorAccepted'=> True]);

            $now=Carbon::now();
            $QueueDir = AlacrityJobs::where('alacrity_id', $jobId)->first();
            $message="<b>Job Acepted in allacrity:</b> $now";
            $message="$QueueDir->history<br>$message";

            $update=[
                'history' => $message,
                'acepted' => 'Y'
            ];
            $QueueDir->update($update);

        } catch (Exception $e) {
            $this->errorHistoryDir($jobId, 'error trying accept alacrity job:', $e->getMessage());
        }

    }

    public function errorHistoryDir($id, $etapa, $error){
        $QueueDir = AlacrityJobs::where('alacrity_id', $id)->first();
        $message="<b>Error $etapa:</b> $error";
        $message="$QueueDir->history<br>$message";

        $update=[
            'status' => 'error',
            'history' => $message
        ];
        $QueueDir->update($update);
    }

    public function search(){
        $alacrity=alacrity_service()->post('SearchAssignment', [],['SearchString'=> 3300340571]);

        dump($alacrity['AssignmentSummaryList'][0]['AssignmentId']);
    }

    public function createJob($AssignmentId)
    {

        $queue=AlacrityJobs::where('alacrity_id',$AssignmentId)->first();

        if($queue->acepted == 'N'){
            // accept job
            $this->acceptJob($AssignmentId);
        }




        // Call alacrity job details
        $job_alacrity=alacrity_service()->post('GetAssignmentDetail', ['AssignmentId'=> $AssignmentId]);

        $job_alacrity=collect($job_alacrity['AssignmentDetail']);


        $jobInfo=$job_alacrity['AssignmentSummary'];
        $jobInfo=(object)$jobInfo;

        $names=explode(' ',$jobInfo->HomeOwner);

        $first=  str_replace(array("#", "'", ";",",",".",":"), '', $names[0]);

        $last=str_replace(array("#", "'", ";",",",".",":"), '', $names[1]);

        $today=Carbon::now();
        $lostDate=Carbon::createFromFormat('m/d/Y', $jobInfo->LossDate)->format('Y-m-d H:i:s');

        $data=[
            'allacrity_id' => $jobInfo->AssignmentId,
            'first_name' => $first,
            'last_name' => $last,
            'street' => $jobInfo->LossAddress,
            'city' => $jobInfo->LossCity,
            'state' => $jobInfo->LossState,
            'zipcode' => $jobInfo->LossZipCode,
            'referral_id' => 24,
            'carrier_id' => 583,
            'created_by' => 73,
            'updated_by' => 73,
            'claim_number' => $jobInfo->ClaimNumber,
            'email' => $jobInfo->HomeOwnerEmail,
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

        $limit=count($job_alacrity['CommentList']);

        if($limit > 0){
            $limit=$limit-1;
            $notes = $job_alacrity['CommentList'][$limit]['CommentString'];
        }else{
            $notes="No Damage loss info in ALACNET!";
        }
        // add notes
//
        $jobData->notes()->create([
            'text'=> $notes,
            'notable_id'=> $created->id,
            'created_by'=> 73,
            'notable_type'=>  Assignment::class,
        ]);

//        // add phones
        $contactInfo=$job_alacrity['InsuredContactList'][0];

        $CellPhone=$contactInfo['CellPhone'];
        $HomePhone=$contactInfo['HomePhone'];
        $BusinessPhone=$contactInfo['BusinessPhone'];

        if($CellPhone != ''){
            AssignmentsPhones::create([
                'assignment_id' => $created->id,
                'phone' => $CellPhone,
            ])->save();
        }

        if($HomePhone != '' && $HomePhone!=$CellPhone  && $HomePhone!=$BusinessPhone){
            AssignmentsPhones::create([
                'assignment_id' => $created->id,
                'phone' => $HomePhone,
            ])->save();
        }

        if($BusinessPhone != '' && $BusinessPhone!=$CellPhone  && $HomePhone!=$BusinessPhone){
            AssignmentsPhones::create([
                'assignment_id' => $created->id,
                'phone' => $BusinessPhone,
            ])->save();
        }

        if($created){
            // adicionou job
            $now=Carbon::now();
            $QueueDir = AlacrityJobs::where('alacrity_id', $AssignmentId)->first();
            $message="<b>Job Added to the system:</b> $now";
            $message="$QueueDir->history<br>$message";

            $update=[
                'history' => $message,
                'status' => 'complete',
                'assignment_id' => $created->id
            ];
            $QueueDir->update($update);
        }


//

            // job accepted message
            $message="### New Job !!! $jobData->full_name $jobData->city - $jobData->state ###";
            send_wpp($message,'new');



//        dump("adicionou o job: $jobInfo->AssignmentId !");

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function updateCC(){

        $alacrity=alacrity_service()->post('UpdateDates',['AssignmentId'=> 2289244],
            ["AssignmentDates" =>[
                'ContactDate'=> '2023-05-24 12:15:00'
//                5/24/2023 01:14:44
            ]]);

        dd($alacrity);
    }
    public function postCC()
    {
        $alacrity=alacrity_service()->post('AddComment',['AssignmentId'=> 2289261],
            ["Comment" =>[
        'CommentString'=> 'teste `by felipe',
        'CommentTypeId'=> 1,
    ]]);

        dd($alacrity);
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
