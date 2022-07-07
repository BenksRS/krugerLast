<?php

namespace Modules\Scheduling\Http\Livewire\Timeline\Assignment;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsStatus;
use Modules\Assignments\Repositories\AssignmentRepository;
use Modules\Scheduling\Support\Traits\Components\WithDistanceMatrix;

class Show extends Component {

    use WithDistanceMatrix;

    protected $listeners = [];

    public    $checklist = [1 => TRUE, 11 => TRUE, 12 => TRUE, 17 => TRUE];

    public    $status;

    public    $addresses;

    public    $offices;

    public function mount ()
    {
        $this->status = AssignmentsStatus::whereIn('id', $this->getChecklist())->get();
        $this->setAddresses();
    }

    public function updated ($name, $value)
    {

    }

    public function changeAddress ($id)
    {
        if ( $id ) {
            $this->setAddresses('id', $id);
        }
    }

    protected function setAddresses ($key = 'default', $value = TRUE)
    {
        $all = collect(_timeline('addresses'));

        $this->addresses = [
            'all'      => $all,
            'selected' => $all->firstWhere($key, $value),
        ];
    }

    protected function getChecklist ($filter = FALSE)
    {
        return array_keys($filter ? array_filter($this->checklist) : $this->checklist);
    }

    public function render ()
    {
        /*        $google = GoogleMaps::distanceMatrix()
                                    ->addOrigin('456 NW 35th St, Boca Raton, FL 33431, US')
                                    ->addDestination('456 NW 35th St, Boca Raton, FL 33431, US')
                                    ->addDestination('1158 Hercules Street, Mobile, AL 36603, USA')
                                    ->addDestination('4223 WINCHESTER AVE, ATLANTIC CITY, NJ 08401')
                                    ->addDestination('133 WINCHESTER WAY, LOCKPORT, LA 70374')
                                    ->addDestination('5952 Winchester Isle Road, Orlando, FL 32829');
                dump($google->resolve());*/

        $assignments = AssignmentRepository::ofStatus($this->getChecklist(TRUE))->limit(5)->get()->sortBy('order_status');

        return view('scheduling::livewire.timeline.assignment.show', [
            'assignments' => $assignments,
        ]);
    }

}
