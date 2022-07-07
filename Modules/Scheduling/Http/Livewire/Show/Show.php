<?php

namespace Modules\Scheduling\Http\Livewire\Show;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsScheduling;
use Modules\Assignments\Entities\AssignmentsStatusPivot;
use Auth;

class Show extends Component
{
    public function mount(){
        $this->user = Auth::user();
    }
//    public function schedulleJobs($JobsReturn){
////        dd($JobsReturn);
//
//        foreach ( $JobsReturn as $jobs){
//            if($jobs['value'] != 'openJobs'){
//                $infos = explode('_',$jobs['value']);
//                $tech_id=$infos[1];
//                $start_date=$infos[3];
//
//                foreach ($jobs['items'] as $item){
//                    $assignment_id=$item['value'];
//
//
//                    $end_date = new \DateTime($start_date); //now
//                    $end_date->add(new \DateInterval('PT1H'));
//
//                    $update=[
//                        'tech_id'=> $tech_id,
//                        'start_date'=> $start_date,
//                        'end_date'=> $end_date,
//                        'updated_by'=> $this->user->id,
//                    ];
//                    $jobSched = AssignmentsScheduling::where('assignment_id',$assignment_id)->first();
//                    if($jobSched){
//                        $jobSched->update($update);
//                    }else{
//                        $update['assignment_id']=$assignment_id;
//                        $update['created_by']=$this->user->id;
//                        $update['updated_by']=$this->user->id;
//                        AssignmentsScheduling::create($update)->save();
//
//                        $AssignmentStatus=[
//                            'assignment_id'  => $assignment_id,
//                            'assignment_status_id'  => 2,
//                            'created_by'  => $this->user->id,
//                        ];
//                        AssignmentsStatusPivot::create($AssignmentStatus);
//                    }
//
//
//
//                    $this->emit('updateJobSchedulled');
//
////                    $this->reloadGridJobs();
////                    $this->dateJobs();
////                    $this->getOpenJobsCity();
//                }
//            }
//
//        }
//
//    }
    public function render()
    {
        return view('scheduling::livewire.show.show');
    }
}
