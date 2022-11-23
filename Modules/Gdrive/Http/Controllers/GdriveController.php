<?php

namespace Modules\Gdrive\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Modules\Assignments\Entities\Assignment;
use Modules\Assignments\Entities\AssignmentsEvents;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Modules\Assignments\Entities\Gallery;
use Modules\Assignments\Entities\JobReport;
use Modules\Assignments\Entities\Signdata;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\Assignments\Repositories\AssignmentFirebaseRepository;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Gdrive\Entities\Gdrive;
use Modules\Gdrive\Entities\QueeDir;
use Modules\Gdrive\Entities\QueeFiles;
use Modules\Gdrive\Entities\QueeForms;
use Modules\Referrals\Entities\FieldAuthorizations;
use Modules\Referrals\Entities\Referral;
use Modules\Referrals\Entities\ReferralAuthorization;

class GdriveController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function queue_forms(){
        $queue=QueeForms::whereIn('status',['pending', 'processing'])->orderBy('order')->first();
        if(isset($queue)) {
            if ($queue->status == 'pending') {

                if($queue->type == 'forms'){
                    // start pdfs forms
                    try {
                        $this->updateHistoryForms($queue->assignment_id, $queue->type, 'start upload Forms pdf`s:');

                        $this->pdfs_auth($queue->assignment_id);
                    } catch (Exception $e) {
//                    $this->errorHistoryFiles($queue->assignment_id, 'on upload Forms pdf`s:', $e->getMessage());
                    }
                    $this->updateHistoryForms($queue->assignment_id, $queue->type,  'Done:');
                    $queue->update(['status' => 'complete']);
                }else{
                    // docusigns

                    $queue->update(['status' => 'complete']);

                }
            }
        }
    }
    public function queue_files()
    {
        $queue=QueeFiles::whereIn('status',['pending', 'processing'])->orderBy('order')->first();
        if(isset($queue)){
            if($queue->status == 'pending'){
                // start uploading images
                try {
                    $this->updateHistoryFiles($queue->assignment_id, 'start upload images:');

                    $this->image($queue->assignment_id);
                } catch (Exception $e) {
                    $this->errorHistoryFiles($queue->assignment_id, 'on uploading images:', $e->getMessage());
                }
                // start pdfs images
                try {
                    $this->updateHistoryFiles($queue->assignment_id, 'start upload pdf`s:');

                    $this->pdfs($queue->assignment_id);
                } catch (Exception $e) {
                    $this->errorHistoryFiles($queue->assignment_id, 'on upload pdf`s:', $e->getMessage());
                }
                // start pdfs forms
                try {
                    $this->updateHistoryFiles($queue->assignment_id, 'start upload Forms pdf`s:');

                    $this->pdfs_auth($queue->assignment_id);
                } catch (Exception $e) {
                    $this->errorHistoryFiles($queue->assignment_id, 'on upload Forms pdf`s:', $e->getMessage());
                }
                $this->updateHistoryFiles($queue->assignment_id, 'Done:');
                $queue->update(['status' => 'complete']);

            }
        }

    }

    public function add_queue_files(){

        $list = AssignmentRepository::where('status_id', 20)->get();
        foreach ($list as $item) {

            $now = Carbon::now();
            QueeFiles::where('assignment_id', $item->id)->delete();

            $history = "<b># Added to queue</b> - $now";
            QueeFiles::create([
                'assignment_id' => $item->id,
                'order' => 50,
                'status' => 'pending',
                'history' => $history
            ])->save();

//if(in_array($item->job_types->toArray)

            if($item->job_types->contains(11)){
                $status_id= 21;
            }else{
                $status_id= 4;
            }


            // change status
            AssignmentsStatusPivot::create([
                'assignment_id'=> $item->id,
                'assignment_status_id'=> $status_id,
                'created_by'=> 73,
            ]);
            $update_status=[
                'status_id'  => $status_id,
                'updated_by'  => 73,
            ];

            $item->update($update_status);
            integration('assignments')->set($item->id);


        }
    }
    public function add_queue_dir(){
        $list = AssignmentRepository::open()->get();
        foreach ($list as $item){
            $queue=QueeDir::where('assignment_id',$item->id)->first();
            if(!isset($queue)){
                $now=Carbon::now();
                $history= "<b># Added to queue</b> - $now";
                QueeDir::create([
                    'assignment_id' =>$item->id,
                    'order' =>50,
                    'status' =>'pending',
                    'history' =>$history
                ])->save();
            }
        }
    }
    public function queue_dir()
    {
        $queue=QueeDir::whereIn('status',['pending', 'processing'])->orderBy('order')->first();
        if(isset($queue)){
            if($queue->status == 'pending'){
                // start creating dir
                $this->create($queue->assignment_id);
            }
        }


    }

    public function pdfs_auth($id){
        $gdrive = gdrive::where('assignment_id', $id)->first();
        $storage=Storage::disk('google');
        $data = Assignment::find($id);
        $auths = $data->authorizations;


        $sign = Signdata::where('assignment_id',$id)->where('preferred','Y')->first();


        if(count($auths) > 0 && isset($sign)){
            $this->updateHistoryFiles($id, 'creating Forms:');
           foreach ($auths as $auth){
               // gera auth


               if($sign == null){
                   $sign = Signdata::where('assignment_id',$id)->latest('id')->first();
               }
               $page = ReferralAuthorization::find($auth->id);
               $fields = FieldAuthorizations::where('referral_authorizathion_id', $page->id)->get();

               if($data){
                   $assignmentview = (object)[
                       'state' => $data->state,
                       'full_name' => "$data->last_name ,$data->first_name",
                       'address' =>  $data->street,
                       'city' =>  $data->city,
                       'zipcode' =>  $data->zipcode,
                       'city_state_zipcode' =>  "$data->city, $data->state, $data->zipcode",
                       'carrier' =>  $data->carrier_info,
                       'claim_number' =>  $data->claim_number,
                       'job_type' =>  'job_type',
                       'dol' =>  $data->dol_date,
                       'date_sign' =>  Carbon::now()->format('Y-m-d'),
                       'day_sign' => Carbon::now()->format('d'),
                       'month_sign' => Carbon::now()->format('m'),
                       'year_sign' =>  Carbon::now()->format('Y'),
                       'single_year_sign' =>  Carbon::now()->format('y'),

                   ];
               }

               $pdf = Pdf::loadView('assignments::pdf', compact('data', 'sign', 'page', 'fields', 'assignmentview'));
               $pdf->setPaper('A4', 'portrait')->setWarnings(false);

               $pdf_file = $pdf->download()->getOriginalContent();

               $base_filename="$page->description - $data->last_name , $data->first_name";
               // send pdf
               $filename ="$gdrive->forms_path/$base_filename.pdf";
               @list($type, $file_data) = explode(';', $pdf_file);
               @list(, $file_data) = explode(',', $file_data);
               $storage->put($filename,$pdf_file);

           }
        }else{
            $this->updateHistoryFiles($id, 'No Forms or Signature Found:');
        }

    }
    public function pdfs($id){

        $gdrive = gdrive::where('assignment_id', $id)->first();
        $storage=Storage::disk('google');
        $data = Assignment::find($id);

        $firstname = $this->clean($data->first_name);
        $lastname = $this->clean($data->last_name);
        $base_filename = "$lastname, $firstname";

        // remove Pics only pdfs
        try {
            $this->updateHistoryFiles($id, 'removing Pics only pdfs:');
            $files = $storage->files($gdrive->kruger_pictures_path);
            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing Pics only pdfs:', $e->getMessage());
        }


        /////// pdf before regular
        try {
            $this->updateHistoryFiles($id, 'creating Pics only before pdf:');
            $pdf = PDF::loadView('assignments::pdfbefore', compact('data'));
            $pdf->setPaper('A4', 'portrait')->setWarnings(false);

            $pdf_file = $pdf->download()->getOriginalContent();

            // send pdf
            $filename ="$gdrive->pictures_path/Before - $base_filename.pdf";
            @list($type, $file_data) = explode(';', $pdf_file);
            @list(, $file_data) = explode(',', $file_data);
            $storage->put($filename,$pdf_file);
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on Pics only before pdf:', $e->getMessage());
        }

        /////// pdf After regular
        try {
            $this->updateHistoryFiles($id, 'creating Pics only after pdf:');
            $pdf = PDF::loadView('assignments::pdfafter', compact('data'));
            $pdf->setPaper('A4', 'portrait')->setWarnings(false);

            $pdf_file = $pdf->download()->getOriginalContent();

            // send pdf
            $filename ="$gdrive->pictures_path/After - $base_filename.pdf";
            @list($type, $file_data) = explode(';', $pdf_file);
            @list(, $file_data) = explode(',', $file_data);
            $storage->put($filename,$pdf_file);
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on Pics only after pdf:', $e->getMessage());
        }
        /////// pdf Kruger Before and after
        try {
            $this->updateHistoryFiles($id, 'creating Kruger Before and after pdf:');
            $pdf = PDF::loadView('assignments::pdfgallery', compact('data'));
            $pdf->setPaper('A4', 'portrait')->setWarnings(false);

            $pdf_file = $pdf->download()->getOriginalContent();

            // send pdf
            $filename ="$gdrive->kruger_pictures_path/Before & After - $base_filename.pdf";
            @list($type, $file_data) = explode(';', $pdf_file);
            @list(, $file_data) = explode(',', $file_data);
            $storage->put($filename,$pdf_file);
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on Kruger Before and after pdf:', $e->getMessage());
        }

        /////// pdf Kruger Label Before and after
        try {
            $this->updateHistoryFiles($id, 'creating Kruger Before and after labeled pdf:');
        $pdf = PDF::loadView('assignments::pdflabel', compact('data'));
        $pdf->setPaper('A4', 'portrait')->setWarnings(false);

        $pdf_file = $pdf->download()->getOriginalContent();

        // send pdf
        $filename ="$gdrive->kruger_pictures_path/Pictures Before & After labeled - $base_filename.pdf";
        @list($type, $file_data) = explode(';', $pdf_file);
        @list(, $file_data) = explode(',', $file_data);
        $storage->put($filename,$pdf_file);

        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on Kruger Before and after labeled pdf:', $e->getMessage());
        }


    }
    public function image($id){
        $gdrive = gdrive::where('assignment_id', $id)->first();
        $gallery = Gallery::where('assignment_id', $id)->get();
        $storage=Storage::disk('google');
        $QueueFile = QueeFiles::where('assignment_id', $id)->first();
        $QueueFile->update(['status' => 'processing']);

        // Kruger front pictures
        // removing old Kruger front pictures
        try {
            $this->updateHistoryFiles($id, 'removing all Kruger front pictures:');

            $files = $storage->files($gdrive->pics_front_kruger_path);
            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing all Kruger front pictures:', $e->getMessage());
        }




        // uploading new Kruger front pictures
        try {
            $this->updateHistoryFiles($id, 'uploading new Kruger front pictures:');

            $count=1;
            foreach ($gallery->where('type','start_job') as $img){
                $filename ="$gdrive->pics_front_kruger_path/front_$count.jpg";
                @list($type, $file_data) = explode(';', $img->b64);
                @list(, $file_data) = explode(',', $file_data);
                $storage->put($filename,base64_decode($file_data));
                $count++;
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on uploading new Kruger front pictures:', $e->getMessage());
        }


        // Kruger inside pictures
        // removing old Kruger inside pictures
        try {
            $this->updateHistoryFiles($id, 'removing all Kruger inside pictures:');
            $files = $storage->files($gdrive->pics_inside_kruger_path);
            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing all Kruger inside pictures:', $e->getMessage());
        }

        // uploading new Kruger inside pictures
        try {
            $this->updateHistoryFiles($id, 'uploading new Kruger inside pictures:');

            $count=1;
            foreach ($gallery->where('type','pics_inside') as $img){
                $filename ="$gdrive->pics_inside_kruger_path/inside_$count.jpg";
                @list($type, $file_data) = explode(';', $img->b64);
                @list(, $file_data) = explode(',', $file_data);
                $storage->put($filename,base64_decode($file_data));
                $count++;
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on uploading new Kruger inside pictures:', $e->getMessage());
        }

        // Kruger before pictures
        // removing old Kruger before pictures
        try {
            $this->updateHistoryFiles($id, 'removing all Kruger before pictures:');
            $files = $storage->files($gdrive->pics_before_kruger_path);

            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing all Kruger before pictures:', $e->getMessage());
        }
        // uploading new Kruger before pictures
        try {
            $this->updateHistoryFiles($id, 'uploading new Kruger before pictures:');
            $count=1;
            foreach ($gallery->where('type','pics_before') as $img){
                $filename ="$gdrive->pics_before_kruger_path/before_$count.jpg";
                @list($type, $file_data) = explode(';', $img->b64);
                @list(, $file_data) = explode(',', $file_data);
                $storage->put($filename,base64_decode($file_data));
                $count++;
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on uploading new Kruger before pictures:', $e->getMessage());
        }


        // Kruger after pictures
        // removing old Kruger after pictures
        try {
            $this->updateHistoryFiles($id, 'removing all Kruger after pictures:');
            $files = $storage->files($gdrive->pics_after_kruger_path);
            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing all Kruger after pictures:', $e->getMessage());
        }
        // uploading new Kruger after pictures
        try {
            $this->updateHistoryFiles($id, 'uploading new Kruger after pictures:');
            $count=1;
            foreach ($gallery->where('type','pics_after') as $img){
                $filename ="$gdrive->pics_after_kruger_path/after_$count.jpg";
                @list($type, $file_data) = explode(';', $img->b64);
                @list(, $file_data) = explode(',', $file_data);
                $storage->put($filename,base64_decode($file_data));
                $count++;
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on uploading new Kruger after pictures:', $e->getMessage());
        }


        // pictures before
        try {
            $this->updateHistoryFiles($id, 'removing all Pics only before pictures:');
            $files = $storage->files($gdrive->pics_before_path);
            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing all Pics only before pictures:', $e->getMessage());
        }

        // uploading new Pics only before pictures
        try {
            $this->updateHistoryFiles($id, 'uploading new Pics only before pictures:');
            $count=1;

            foreach ($gallery->whereIn('type',['start_job', 'pics_inside', 'pics_before']) as $img){
                $filename ="$gdrive->pics_before_path/pics_before_$count.jpg";
                @list($type, $file_data) = explode(';', $img->b64);
                @list(, $file_data) = explode(',', $file_data);
                $storage->put($filename,base64_decode($file_data));
                $count++;
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on uploading new Pics only before pictures:', $e->getMessage());
        }



        // pictures after
        try {
            $this->updateHistoryFiles($id, 'removing all Pics only after pictures:');
            $files = $storage->files($gdrive->pics_after_path);
            foreach ($files as $file){
                $storage->delete($file);
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on removing all Pics only after pictures:', $e->getMessage());
        }
        // uploading new Pics only before pictures
        try {
            $this->updateHistoryFiles($id, 'uploading new Pics only after pictures:');
            $count=1;

            foreach ($gallery->where('type','pics_after') as $img){
                $filename ="$gdrive->pics_after_path/pics_after_$count.jpg";
                @list($type, $file_data) = explode(';', $img->b64);
                @list(, $file_data) = explode(',', $file_data);
                $storage->put($filename,base64_decode($file_data));
                $count++;
            }
        } catch (Exception $e) {
            $this->errorHistoryFiles($id, 'on uploading new Pics only after pictures:', $e->getMessage());
        }

//        dd($gallery);
    }
    public function updateHistoryFiles($id, $etapa){
        $now=Carbon::now();
        $QueueDir = QueeFiles::where('assignment_id', $id)->first();
        $message="<b>$etapa:</b> $now";
        $message="$QueueDir->history<br>$message";

        $update=[
            'history' => $message
        ];
        $QueueDir->update($update);
    }
    public function updateHistoryForms($id, $type,$etapa){
        $now=Carbon::now();
        $QueueDir = QueeForms::where('assignment_id', $id)->where('types',$type)->first();
        $message="<b>$etapa:</b> $now";
        $message="$QueueDir->history<br>$message";

        $update=[
            'history' => $message
        ];
        $QueueDir->update($update);
    }
    public function updateHistoryDir($id, $etapa){
        $now=Carbon::now();
        $QueueDir = QueeDir::where('assignment_id', $id)->first();
        $message="<b>$etapa:</b> $now";
        $message="$QueueDir->history<br>$message";

        $update=[
            'history' => $message
        ];
        $QueueDir->update($update);
    }
    public function errorHistoryDir($id, $etapa, $error){
        $QueueDir = QueeDir::where('assignment_id', $id)->first();
        $message="<b>Error $etapa:</b> $error";
        $message="$QueueDir->history<br>$message";

        $update=[
            'status' => 'error',
            'history' => $message
        ];
        $QueueDir->update($update);
    }
    public function errorHistoryFiles($id, $etapa, $error){
        $QueueDir = QueeFiles::where('assignment_id', $id)->first();
        $message="<b>Error $etapa:</b> $error";
        $message="$QueueDir->history<br>$message";

        $update=[
            'status' => 'error',
            'history' => $message
        ];
        $QueueDir->update($update);
    }
    public function create($id){
        $assignments = Assignment::find($id);

        $firstname = $this->clean($assignments->first_name);
        $lastname = $this->clean($assignments->last_name);
        $base_dir_name = "$lastname, $firstname ($id)";

        $QueueDir = QueeDir::where('assignment_id', $id)->first();
        $QueueDir->update(['status' => 'processing']);

        $this->updateHistoryDir($id, 'Start processing:');

        // create base path
        try {
            $this->updateHistoryDir($id, 'Creating job dir:');
            $this->basePath($base_dir_name, $id);
        } catch (Exception $e) {
            $this->errorHistoryDir($id, 'create job dir:', $e->getMessage());
        }


        // create kruger picture dir
        try {
            $this->updateHistoryDir($id, 'Creating Kruger Pictures dir:');
            $this->krugerPictures($id);
        } catch (Exception $e) {
            $this->errorHistoryDir($id, 'create Kruger Pictures dir:', $e->getMessage());
        }

        // create pictures dir
        try {
            $this->updateHistoryDir($id, 'Creating Pics Only dir:');
            $this->pictures($id);
        } catch (Exception $e) {
            $this->errorHistoryDir($id, 'create Pics Only dir:', $e->getMessage());
        }

        // create forms dir
        try {
            $this->updateHistoryDir($id, 'Creating Forms dir:');
            $this->createforms($id);
        }catch (Exception $e) {
            $this->errorHistoryDir($id, 'create Forms dir:', $e->getMessage());
        }

        $gdrive = gdrive::where('assignment_id', $id)->first();

        if(
            isset($gdrive->job_path) &&
            isset($gdrive->kruger_pictures_path) &&
            isset($gdrive->pics_front_kruger_path) &&
            isset($gdrive->pics_inside_kruger_path) &&
            isset($gdrive->pics_before_kruger_path) &&
            isset($gdrive->pics_after_kruger_path) &&
            isset($gdrive->pictures_path) &&
            isset($gdrive->pics_before_path) &&
            isset($gdrive->pics_after_path) &&
            isset($gdrive->forms_path) &&
            isset($gdrive->job_link) &&
            isset($gdrive->kruger_pictures_link) &&
            isset($gdrive->pics_link) &&
            isset($gdrive->forms_link)
        ){
            $this->updateHistoryDir($id, 'Done:');
            $QueueDir->update(['status' => 'complete']);
        }else{
            $this->errorHistoryDir($id, 'checking folders:', 'something went wrong!!!');
            $QueueDir->update(['status' => 'error']);
        }


    }

    public function basePath($base_dir_name, $id) {

        $storage=Storage::disk('google');

        // check if exist folder and clean up
        $dir_cliente = collect($storage->listContents('/', false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $base_dir_name);

        // deleta folders existentes
        if(count($dir_cliente) > 0){
            foreach ($dir_cliente as $dir){
                $storage->deleteDirectory($dir['basename']);
            }
        }
        // apaga no db registros
        gdrive::where('assignment_id', $id)->delete();

        // cria nova pasta
        $storage->makeDirectory($base_dir_name);

        $dir_cliente = collect($storage->listContents('/', false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $base_dir_name)->first();

        $dir_cliente_path=$dir_cliente['basename'];
        $job_link=$storage->url($dir_cliente_path);
        // cria novo registro no db
        gdrive::create([
            'assignment_id'=> $id,
            'job_path'=> $dir_cliente_path,
            'job_link'=> $job_link,
        ]);


    }

    public function krugerPictures($id)
    {
        $gdrive = gdrive::where('assignment_id', $id)->first();
        $storage=Storage::disk('google');

        // Kruger Pictures
        $kruger_pictures = 'Kruger Pictures';
        $storage->makeDirectory("$gdrive->job_path/$kruger_pictures");

        $dir_cliente_kruger_picutes = collect($storage->listContents($gdrive->job_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_pictures)
            ->where('dirname', '=', $gdrive->job_path)
            ->first();

        $dir_Kruger_path=$dir_cliente_kruger_picutes['basename'];
        $dir_Kruger_link=$storage->url($dir_Kruger_path);

        //// Kruger Pictures - 1- Pics - Front of the House
        $kruger_front = "1- Pics - Front of the House";
        $storage->makeDirectory("$dir_Kruger_path/$kruger_front");

        $dir_cliente_kruger_pictures_front = collect($storage->listContents($dir_Kruger_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_front)
            ->where('dirname', '=', $dir_Kruger_path)
            ->first();

        $pics_front_kruger_path=$dir_cliente_kruger_pictures_front['basename'];

        //// Kruger Pictures - 2- Pics - Inside of the House
        $kruger_inside = "2- Pics - Inside of the House";
        $storage->makeDirectory("$dir_Kruger_path/$kruger_inside");

        $dir_cliente_kruger_pictures_inside = collect($storage->listContents($dir_Kruger_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_inside)
            ->where('dirname', '=', $dir_Kruger_path)
            ->first();

        $pics_inside_kruger_path=$dir_cliente_kruger_pictures_inside['basename'];

        //// Kruger Pictures -"3- Pics - Before"
        $kruger_before = "3- Pics - Before";
        $storage->makeDirectory("$dir_Kruger_path/$kruger_before");

        $dir_cliente_kruger_pictures_before = collect($storage->listContents($dir_Kruger_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_before)
            ->where('dirname', '=', $dir_Kruger_path)
            ->first();

        $pics_before_kruger_path=$dir_cliente_kruger_pictures_before['basename'];

        //// Kruger Pictures -"4- Pics - After"
        $kruger_after = "4- Pics - After";
        $storage->makeDirectory("$dir_Kruger_path/$kruger_after");

        $dir_cliente_kruger_pictures_after = collect($storage->listContents($dir_Kruger_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_after)
            ->where('dirname', '=', $dir_Kruger_path)
            ->first();

        $pics_after_kruger_path=$dir_cliente_kruger_pictures_after['basename'];

        // update kruger pictures in db
        $gdrive->update([
            'kruger_pictures_path' => $dir_Kruger_path,
            'kruger_pictures_link' => $dir_Kruger_link,
            'pics_front_kruger_path' => $pics_front_kruger_path,
            'pics_inside_kruger_path' => $pics_inside_kruger_path,
            'pics_before_kruger_path' => $pics_before_kruger_path,
            'pics_after_kruger_path' => $pics_after_kruger_path,
        ]);



    }
    public function pictures($id)
    {
        $gdrive = gdrive::where('assignment_id', $id)->first();
        $storage=Storage::disk('google');

        // Pictures
        $Pictures = 'Pictures';
        $storage->makeDirectory("$gdrive->job_path/$Pictures");

        $dir_cliente_picutes = collect($storage->listContents($gdrive->job_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $Pictures)
            ->where('dirname', '=', $gdrive->job_path)
            ->first();

        $dir_pictures_path=$dir_cliente_picutes['basename'];
        $dir_pictures_link=$storage->url($dir_pictures_path);

        //// Pictures -1- Pics - Before
        $pictures_before = "1- Pics - Before";
        $storage->makeDirectory("$dir_pictures_path/$pictures_before");

        $dir_cliente_pictures_before = collect($storage->listContents($dir_pictures_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $pictures_before)
            ->where('dirname', '=', $dir_pictures_path)
            ->first();

        $pics_before_path=$dir_cliente_pictures_before['basename'];
//        dump($pics_before_path);

        //// Pictures -1- Pics - After
        $pictures_after = "2- Pics - After";
        $storage->makeDirectory("$dir_pictures_path/$pictures_after");

        $dir_cliente_pictures_after = collect($storage->listContents($dir_pictures_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $pictures_after)
            ->where('dirname', '=', $dir_pictures_path)
            ->first();

        $pics_after_path=$dir_cliente_pictures_after['basename'];
//dump($pics_after_path);

        // update kruger pictures in db
        $gdrive->update([
            'pictures_path' => $dir_pictures_path,
            'pics_link' => $dir_pictures_link,
            'pics_before_path' => $pics_before_path,
            'pics_after_path' => $pics_after_path,

        ]);



    }
    public function createforms($id)
    {
        $gdrive = gdrive::where('assignment_id', $id)->first();
        $storage=Storage::disk('google');

        // Pictures
        $forms = 'Authorization Forms';
        $storage->makeDirectory("$gdrive->job_path/$forms");

        $dir_cliente_forms = collect($storage->listContents($gdrive->job_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $forms)
            ->where('dirname', '=', $gdrive->job_path)
            ->first();

        $dir_forms_path=$dir_cliente_forms['basename'];
//        dump($dir_forms_path);
        $dir_forms_link=$storage->url($dir_forms_path);
//        dump($dir_forms_link);
        // update kruger pictures in db
        $gdrive->update([
            'forms_path' => $dir_forms_path,
            'forms_link' => $dir_forms_link,
        ]);



    }
    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

        return preg_replace('/-+/', ' ', $string); // Replaces multiple hyphens with single one.
    }
    public function index()
    {
        return view('gdrive::index');
    }


    public function gdrive (){

        $storage=Storage::disk('google');

        $dir_job = 'job_teste (123456)';
        $storage->makeDirectory($dir_job);


        $dir_cliente = collect($storage->listContents('/', false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $dir_job)->first();

        $dir_cliente_path=$dir_cliente['basename'];

        dump('cliente pasta');
        dump($dir_cliente_path);

        // Kruger Pictures
        $storage_dir_cliente = $storage->directories($dir_cliente_path);
        $kruger_pictures = 'Kruger Pictures';
        $storage->makeDirectory("$dir_cliente_path/$kruger_pictures");

        $dir_cliente_kruger_picutes = collect($storage->listContents($dir_cliente_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_pictures)
            ->where('dirname', '=', $dir_cliente_path)
            ->first();

        $dir_Kruger_path=$dir_cliente_kruger_picutes['basename'];
        dump('Kruger Pictures');
        dump($dir_Kruger_path);


        // Authorization Forms
        $storage_dir_cliente = $storage->directories($dir_cliente_path);
        $kruger_forms = 'Authorization Forms';
        $storage->makeDirectory("$dir_cliente_path/$kruger_forms");

        $dir_cliente_forms_picutes = collect($storage->listContents($dir_cliente_path, false))
            ->where('type', '=', 'dir')
            ->where('filename', '=', $kruger_forms)
            ->where('dirname', '=', $dir_cliente_path)
            ->first();

        $dir_forms_path=$dir_cliente_forms_picutes['basename'];
        dump('Authorization Forms');
        dump($dir_forms_path);

    }
    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */


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
        return view('gdrive::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('gdrive::edit');
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

    public function job_report_import(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
        $base_path="DB/1/";
                //$job_report
        $job_report_file = fopen(base_path("$base_path/db_031_job_report_new.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($job_report_file, 2000, ",")) !== FALSE) {
            if (!$firstline) {

                $tarp_situation=$data['7'];
                if($tarp_situation == 2 || $tarp_situation == 4){
                    $tarp_situation='Y';
                }else{
                    $tarp_situation='N';
                }

                if(empty($data['4']) || is_null($data['4'])){
                    $sandbag=0;
                }else{
                    $sandbag=$data['4'];
                }




                $job= JobReport::where('assignment_id', $data['0'])->where('assignment_job_type_id', $data['1'])->first();
                if($job) {
                    $job_report = [
                        'assignment_id' => $data['0'],
                        'assignment_job_type_id' => $data['1'],
                        'service_date' => $data['2'],
                        'pitch' => $data['3'],
                        'sandbags' => $sandbag,
                        'created_by' => $data['5'],
                        'updated_by' => $data['6'],
                        'tarp_situation' => $tarp_situation,
                        'plywoods' => $data['8'],
                        's2x4x8' => $data['9'],
                        's2x4x12' => $data['10'],
                        's2x4x16' => $data['11'],
                        'job_info' => $data['12'],
                    ];

                    $job->update($job_report);
                }else{
                    $job_report = [
                        'assignment_id' => $data['0'],
                        'assignment_job_type_id' => $data['1'],
                        'service_date' => $data['2'],
                        'pitch' => $data['3'],
                        'sandbags' => $sandbag,
                        'created_by' => $data['5'],
                        'updated_by' => $data['6'],
                        'tarp_situation' => $tarp_situation,
                        'plywoods' => $data['8'],
                        's2x4x8' => $data['9'],
                        's2x4x12' => $data['10'],
                        's2x4x16' => $data['11'],
                        'job_info' => $data['12'],
                    ];

                    JobReport::insert($job_report);
                }


            }
            $firstline = false;

        }

        fclose($job_report_file);

    }
    public function lien_import(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
        $base_path="DB/1/";
        $file_open = fopen(base_path("$base_path/import_lien_info.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 20000, ",")) !== FALSE) {
            if (!$firstline) {
                $job= Assignment::find($data['0']);
                if($job){
                    $update=[
                        'lien_date' => $data['1'],
                        'lien_info' => $data['2']
                    ];
                    $job->update($update);
                }
            }
            $firstline = false;
        }
        fclose($file_open);
    }
    public function claim_import(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
        $base_path="DB/1/";
        $file_open = fopen(base_path("$base_path/claim_number.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 20000, ",")) !== FALSE) {
            if (!$firstline) {
                $job= Assignment::find($data['0']);
                if($job){
                    $update=[
                        'claim_number' => $data['1']
                    ];
                    $job->update($update);
                }
            }
            $firstline = false;
        }
        fclose($file_open);

    }
    public function marketing_rep()
    {

        $base_path="DB/scripts/";
        $file_open = fopen(base_path("$base_path/referrals_marketingrep.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($file_open, 2000, ",")) !== FALSE) {
            if (!$firstline) {


                switch($data['1']){
                    case 10:
                        $marketing_rep=11;
                        break;
                    case 17:
                        $marketing_rep=16;
                        break;
                    case 45:
                        $marketing_rep=50;
                        break;
                    case 44:
                        $marketing_rep=49;
                        break;
                    default:
                        $marketing_rep=null;
                        break;
                }


                $referral= Referral::find($data['0']);
                if($referral){
                    $update=[
                        'marketing_id' => $marketing_rep
                    ];
                    $referral->update($update);
                }
            }
            $firstline = false;
        }
        fclose($file_open);


    }
    public function adjust_gdrive()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');
        $base_path="DB/1/";

        //   Gdrive
        $adjust_gdrive = fopen(base_path("$base_path/ajust_gdrive.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($adjust_gdrive, 2000, ",")) !== FALSE) {
            if (!$firstline) {
                $gdrive=[
                    "assignment_id" => $data['0'],
                    "job_path" => $data['1'],
                    "kruger_pictures_path" => $data['2'],
                    "pics_front_kruger_path" => $data['3'],
                    "pics_inside_kruger_path" => $data['4'],
                    "pics_before_kruger_path" => $data['5'],
                    "pics_after_kruger_path" => $data['6'],
                    "pictures_path" => $data['7'],
                    "pics_before_path" => $data['8'],
                    "pics_after_path" => $data['9'],
                    "forms_path" => $data['10'],
                    "job_link" => $data['11'],
                    "pics_link" => $data['12'],
                    "kruger_pictures_link" => $data['13']
                ];
                Gdrive::insert($gdrive);
            }
            $firstline = false;


        }
        fclose($adjust_gdrive);


    }

    public function check_finance(){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');


        $assignmnet=AssignmentFinanceRepository::DateSchedulled('2022-01-01', Carbon::now())->whereIn('status_id', [6,10,24])->get();

        foreach ($assignmnet as $row){

            $status_finance= $row->finance->balance->status;
            if($status_finance!='pending'){

                if($row->status_id != $status_finance){
                    AssignmentsStatusPivot::create([
                        'assignment_id'=> $row->id,
                        'assignment_status_id'=> $status_finance,
                        'created_by'=> 73,
                    ]);
                    $update_status=[
                        'status_id'  => $status_finance,
                        'updated_by'  => 73,
                    ];

                    $status_collection=array(5,6);
                    if(in_array($status_finance, $status_collection)){
                        $update_status['status_collection_id']=$status_finance;
                    }


                    $row->update($update_status);

                }

            }


        }



    }
    public function fix_address(){
        $assignments=AssignmentRepository::whereLike('city', "'")->whereLike('street', "'")->get();
        $this->cleamCleam($assignments);


    }
    public function cleamCleam($jobs){
        foreach ($jobs as $job){
            $update['city']=str_replace( array( "`", "'"), "",  $job->city);
            $update['street']=str_replace( array( "`", "'"), "",  $job->street);
            $job->update($update);
        }
    }



    public function adjust_images($id)
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2512M');


        $base_path="DB/1/";

        //   $adjust_images
        $adjust_images = fopen(base_path("$base_path/import_pictures_$id.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($adjust_images, 20000, ",")) !== FALSE) {
            if (!$firstline) {



                    if(is_null($data['7']) || empty($data['7'])){
                        $category_id = 25;
                    }else{
                        $category_id = $data['7'];
                    }

                    $gallery=[
                        "assignment_id" => $data['3'],
                        "category_id" => $category_id,
                        "created_by" => 73,
                        "updated_by" => 73,
                        "img_id" => $data['1'],
                        "b64" => $data['2'],
                        "type" => $data['6']
                    ];
                    Gallery::insert($gallery);
                }


            $firstline = false;


        }
        fclose($adjust_images);




    }

}
