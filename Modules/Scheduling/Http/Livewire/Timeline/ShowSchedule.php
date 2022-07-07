<?php

namespace Modules\Scheduling\Http\Livewire\Timeline;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsScheduling;
use Modules\Scheduling\Support\Traits\Components\WithTimeline;
use Modules\User\Entities\Techs;
use Modules\User\Entities\User;

class ShowSchedule extends Component {

    use WithTimeline;

    public    $techs;
    public    $scheduling;


    protected $listeners = ['updateEvent'];

    public function mount ()
    {
        $this->techs = Techs::all();
        $this->getTimeline();

        $this->scheduling = AssignmentsScheduling::whereDate('start_date', $this->timelineDate)->get();
    }

    public function updateEvent ($data)
    {
        if ( !$data ) {
            return;
        }

        $check_user_data_schedule = AssignmentsScheduling::where('start_date',$data['start']['date'])->where('end_date',$data['end']['date'])->where('tech_id',$data['tech_id'])->get();

        if(count($check_user_data_schedule) == 0){
            AssignmentsScheduling::where('assignment_id',$data['assignment_id'])->update(
                [
                    'tech_id'    => $data['tech_id'],
                    'start_date' => $data['start']['date'],
                    'end_date'   => $data['end']['date'],
                ]
            );
        }
        $this->getTimeline();
        $this->scheduling = AssignmentsScheduling::whereDate('start_date', $this->timelineDate)->get();

    }

    public function render ()
    {
        $this->getTimeline();
        $this->scheduling = AssignmentsScheduling::whereDate('start_date', $this->timelineDate)->get();

        return view('scheduling::livewire.timeline.schedule', [
            'schedulling' => $this->scheduling
        ]);
    }

}
