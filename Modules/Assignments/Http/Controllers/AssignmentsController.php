<?php

namespace Modules\Assignments\Http\Controllers;

use Barryvdh\Debugbar\Storage\SocketStorage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\Docsign;
use Modules\Assignments\Entities\Signdata;
use Modules\Core\Http\Controllers\AdminController;
use Modules\Referrals\Entities\FieldAuthorizations;
use Modules\Referrals\Entities\Referral;
use Illuminate\Support\Facades\File;
use League\Flysystem\Filesystem;
use Modules\Referrals\Entities\ReferralAuthorization;

class AssignmentsController extends Controller {


    public function __construct ()
    {
        $this->middleware('auth:user');
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function gdrive (){

    }
    public function index ()
    {

        $page_info = (object)[
            'title' => 'Assignments List',
            'back' => url('assignments'),
            'back_title' => 'Assignments List'
        ];

        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('assignments::index', compact('page'));
    }

    public function new ()
    {
        $page_info = (object)[
            'title' => 'New Assignment',
            'back' => url('assignments'),
            'back_title' => 'Assignments List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('assignments::new', compact('page'));

    }
    public function tags ()
    {
        $page_info = (object)[
            'title' => 'Tags & Events Manager',
            'back' => url('general/tags'),
            'back_title' => 'Tags & Events Manager'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');

        return view('assignments::general_tags', compact('page'));

    }
    public function open ()
    {

        return view('assignments::indexbkp');
    }
    public function list ()
    {
        return view('assignments::list');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create ()
    {
        return view('assignments::create');
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

        $assignment = Assignment::findOrFail($id);

        $page_info = (object)[
            'title' => 'Assignment Information',
            'back' => url('assignments'),
            'back_title' => 'Assignments List'
        ];
        \session()->flash('page',$page_info);
        $page =\session()->get('page');


//        return view('referrals::show', compact('referral','page'));
        return view('assignments::livewire.show.show', compact('assignment','page'));
//        $assignment = Assignment::findOrFail($id);
//
//        if ( $assignment ) {
//            $back = route('assignments.index');
//
//            echo "<h2>JOB: #{$assignment->id}  <a href='{$back}'> << back</a></h2>";
//            echo "<h3>Status: {$assignment->last_status->name}</h3>";
//
//
//
//            $created_by = $assignment->user_created;
//            if ( $created_by ) {
//                echo "<p>( Created by {$created_by->id}-{$created_by->name} at {$assignment->created_at} )</p>";
//            }
//            $updated_by = $assignment->user_updated;
//            if ( $created_by ) {
//                echo "<p>( Last updated by {$updated_by->name} at {$assignment->updated_at} )</p>";
//            }
//            echo "<p>H.o. Name: {$assignment->last_name}, {$assignment->first_name}</p>";
//            echo "<p>Email: {$assignment->email} </p>";
//            echo "<p>ADDRESS: {$assignment->address}</p>";
//            echo "<p>Claim info: {$assignment->claim_number}</p>";
//            echo "<p>Dol: {$assignment->date_of_loss}</p>";
//            echo "<p>Adjuster info: {$assignment->adjuster_info}</p>";
//
//        }
//
//        $referral = $assignment->referral->first();
//
//        if ( $referral ) {
//            echo "<h3>Referral:</h3>";
//
//            $carrier = $assignment->carrier()->first();
//
//            if ( $carrier ) {
//                echo "<p>{$referral->company_fictitions} - ( {$carrier->company_fictitions} )</p>";
//            } else {
//                echo "<p>{$referral->company_fictitions} - ({$assignment->carrier})</p>";
//            }
//        }
//
//        $phones = $assignment->phones;
//        if ( $phones->isNotEmpty() ) {
//            echo "<h3>Phones:</h3>";
//            foreach ( $phones as $phone ) {
//                echo "<p>{$phone->contact} - {$phone->phone} ({$phone->preferred})</p>";
//            }
//        }
//        $job_types = $assignment->job_types;
//        if ( $job_types->isNotEmpty() ) {
//            echo "<h3>Job Types:</h3>";
//            foreach ( $job_types as $job_type ) {
//                echo "<p>{$job_type->name}</p>";
//            }
//        }
//        $status_history = $assignment->status_history;
//        if ( $status_history ) {
//            echo "<h3>Status history:</h3>";
//            foreach ( $status_history as $status_row ) {
//                //                dd($status_row);
//                echo "<p>{$status_row->status->name} - ( by {$status_row->user->name} at {$status_row->created_at} )</p>";
//            }
//        }
//
//        $authorizations = $assignment->authorizations;
//        if ( $authorizations->isNotEmpty() ) {
//            //                dd($authorizations);
//            echo "<h2>Authorizations:</h2>";
//            foreach ( $authorizations as $authorization ) {
//                echo "<p>{$authorization->name}  ({$authorization->b64})</p>";
//            }
//        }
//
//        $tags = $assignment->tags;
//        if ( $tags->isNotEmpty() ) {
//            //                dd($authorizations);
//            echo "<h2>Tags:</h2>";
//            foreach ( $tags as $tag ) {
//                echo "<p>( {$tag->name} )</p>";
//            }
//        }
//        //        dd($assignment->event);
//        $event = $assignment->event;
//
//        if ( $event ) {
//            echo "<h2>Event:</h2>";
//            echo "<p>( {$event->name} )</p>";
//        }
//
//        $notes = $assignment->notes;
//
//        if ( $notes ) {
//
//            echo "<h2>Notes:</h2>";
//            foreach ( $notes as $note ) {
//                echo "<p> {$note->text} - ( by {$note->user->name} at {$note->created_at} )</p>";
//            }
//        }
//        $scheduling = $assignment->scheduling;
//
//        if ( $scheduling ) {
//            echo "<h2>Scheduling:</h2>";
//            echo "<p>({$scheduling->start_date} btw {$scheduling->end_date} Technician: {$scheduling->tech->name} - Scheduled by {$scheduling->user->name} at {$scheduling->created_at})</p>";
//        }
//
//        $gallery = $assignment->gallery;
//        if ( $gallery ) {
//            echo "<h3>Gallery:</h3>";
//            foreach ( $gallery as $gallery_row ) {
//                echo "<p>{$gallery_row->id} -  <img src='{$gallery_row->b64}' width='160px' height='160px'> {$gallery_row->category->name}</p>";
//            }
//        }
//        echo "<br><br>";
    }
    public function docsignfile($id){
        $docusignFile =Docsign::find($id);
        $pdf = base64_decode($docusignFile->b64, true);

        return response($pdf)
            ->withHeaders([
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.$docusignFile->name.'"'
            ]);







    }
    public function pdfgallerylabel($id)
    {

        $data = Assignment::find($id);
        $pdf = PDF::loadView('assignments::pdflabel', compact('data'));
        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        return $pdf->stream("After & Before - $data->last_name , $data->first_name.pdf");


    }
    public function pdfgallery($id)
    {
        $data = Assignment::find($id);
        $pdf = PDF::loadView('assignments::pdfgallery', compact('data'));
        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        return $pdf->stream("After & Before - $data->last_name , $data->first_name.pdf");


    }
    public function pdfgalleryafter($id)
    {
        $data = Assignment::find($id);
        $pdf = PDF::loadView('assignments::pdfafter', compact('data'));
        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        return $pdf->stream("After - $data->last_name , $data->first_name.pdf");


    }
    public function pdfgallerybefore($id)
    {


        $data = Assignment::find($id);
        $pdf = PDF::loadView('assignments::pdfbefore', compact('data'));
        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        return $pdf->stream("Before - $data->last_name , $data->first_name.pdf");


    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Renderable
     */
    public function pdfauth($id, $page)
    {
        $data = Assignment::find($id);
        $sign = Signdata::where('assignment_id',$id)->where('preferred','Y')->first();
//        dd($sign);
        if($sign == null){
            $sign = Signdata::where('assignment_id',$id)->latest('id')->first();
        }
        $page = ReferralAuthorization::find($page);
        $fields = FieldAuthorizations::where('referral_authorizathion_id', $page->id)->get();

        if($data){

            if(!empty($data->carrier->company_entity)){
               $carrier =$data->carrier->company_entity;
            }else{
                $carrier= $data->carrier_info;
            }
              $count=0;
                                           foreach($data->job_types as $job){
                                                $count++;
                                                if($count == 1){
                                                    $job_types=$job->name;
                                                }else{
                                                    $job_types="$job_types / $job->name";
                                                }
                                          }


                                           $data_schd = $data->scheduling->schedule_date ?? '';
            $assignmentview = (object)[
                'state' => $data->state,
                'full_name' => "$data->last_name ,$data->first_name",
                'address' =>  $data->street,
                'city' =>  $data->city,
                'zipcode' =>  $data->zipcode,
                'city_state_zipcode' =>  "$data->city, $data->state, $data->zipcode",
                'carrier' =>  $carrier,
                'claim_number' =>  $data->claim_number,
                'job_type' =>  $job_types,
                'dol' =>  $data->dol_date,
                'date_sign' =>  $data_schd,
                'day_sign' => Carbon::parse($data_schd)->format('d'),
                'month_sign' => Carbon::parse($data_schd)->format('m'),
                'year_sign' =>  Carbon::parse($data_schd)->format('Y'),
                'single_year_sign' =>  Carbon::parse($data_schd)->format('y'),

            ];
//            dd($assignmentview);
        }

        $pdf = Pdf::loadView('assignments::pdf', compact('data', 'sign', 'page', 'fields', 'assignmentview'));

        $pdf->setPaper('A4', 'portrait');
//
//        $path2 = public_path('kruger_jobs/' . $data->id . '/pdf');
//        if (!File::exists($path2)) {
//
//            File::makeDirectory($path2, $mode = 0777, true, true);
//        }
//
//        $pdf->save(public_path("kruger_jobs/$data->id/pdf/$page->filename - $data->last_name , $data->first_name.pdf"));

        return $pdf->stream("$page->filename - $data->last_name , $data->first_name.pdf");

    }


    public function edit ($id)
    {
        return view('assignments::indexbkp');
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