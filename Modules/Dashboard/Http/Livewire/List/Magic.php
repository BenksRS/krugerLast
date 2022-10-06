<?php

namespace Modules\Dashboard\Http\Livewire\List;

use Carbon\Carbon;
use http\Client\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Assignments\Entities\AssignmentsPhones;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Notes\Entities\Note;
use Modules\Referrals\Entities\Referral;
use Auth;

class Magic extends Component
{
    use WithPagination;

    public $searchAssignment;
    public $columns = ['Name','Job Type','Schedule','Status','Referral','Address','Street','City','State', 'Phone', 'Created by', 'Created At', 'Update By','Update At'];
    public $selectedColumns = [];
    public $selectedRows = 100;
    public $user;

    public function mount()
    {
        $this->selectedColumns = $this->columns;
        $this->user = Auth::user();

    }
    public function updatingSearchAssignment()
    {
        $this->resetPage();
    }
    public function export()
    {
        $now=Carbon::now();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=open_jobs_$now.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $reviews = AssignmentRepository::messages()->get();
        $columns = array('first_name', 'last_name', 'id');

        $callback = function() use ($reviews)
        {
            $file = fopen('php://output', 'w');

            foreach($reviews as $review) {

                $phone=AssignmentsPhones::where('assignment_id', $review->id)->first();

                if(isset($phone)){
                    $phone_number=$phone->phone;
                }else{
                    $phone_number='';
                }

                $check_carrier=array(582,583);

                if(isset($review->carrier_id)){
                    if(!in_array($review->carrier_id, $check_carrier)){
                        $carrier=Referral::find($review->carrier_id);
                        $carrier_name=$carrier->company_entity;
                    }else{
                        $carrier_name='';
                    }
                }else{
                    if($review->carrier_info){
                        $carrier_name=$review->carrier_info;
                    }else{
                        $carrier_name='';
                    }

                }

                if($review->claim_number){
                    $claim = $review->claim_number;
                }else{
                    $claim = '';
                }
                fputcsv($file, array($review->first_name, $review->last_name, $phone_number, $carrier_name, $review->id, $claim, $review->address->message));

                $update_status=[
                    'status_id'  => 28,
                    'updated_by'  => $this->user->id,
                ];
                $review->update($update_status);

                Note::create([
                    'text'=> "### CHANGE STATUS TO: MESSAGE SENT ### ",
                    'notable_id'=> $review->id,
                    'created_by'=> $this->user->id,
                    'type'=> 'assignment',
                    'notable_type'=>  'Modules\Assignments\Entities\Assignment',
                ]);

            }
            fclose($file);



        };



        return response()->stream($callback, 200, $headers);
    }

    public function render()
    {
        $searchAssignment = $this->searchAssignment;
        $list = AssignmentRepository::messages()->search($searchAssignment)->get();
//
//        $list = $list->sortBy('start_date')->sortBy('order_status');
//
//        $items = $list->forPage($this->page, $this->selectedRows);
//
//        $list = new LengthAwarePaginator($items, $list->count(), $this->selectedRows, $this->page);

        return view('dashboard::livewire.list.messages', [
            'list' => $list
        ]);

    }
}
