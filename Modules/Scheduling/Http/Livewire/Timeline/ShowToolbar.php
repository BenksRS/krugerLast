<?php

namespace Modules\Scheduling\Http\Livewire\Timeline;

use DateTime;
use Livewire\Component;

class ShowToolbar extends Component {

    public $date;

    public $label;

    public function mount ()
    {
        $this->setDate();
    }

    public function changeDate ($action)
    {
        $modify = $action == 'prev' ? '-1' : '+1';
        $this->setDate($modify);
    }

    protected function setDate ($modify = NULL)
    {
        $dateTime = new DateTime($this->date ?? 'now');
        if ( $modify ) {
            $dateTime->modify("$modify day");
        }

        $this->date  = $dateTime->format("Y-m-d");
        $this->label = $dateTime->format("d F, Y");

        $this->emit('changeDate', $this->date);
    }

    public function render ()
    {
        return view('scheduling::livewire.timeline.toolbar');
    }

}
