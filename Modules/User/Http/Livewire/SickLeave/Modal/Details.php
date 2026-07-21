<?php

namespace Modules\User\Http\Livewire\SickLeave\Modal;

use Livewire\Component;
use Modules\User\Entities\SickLeave;

class Details extends Component {

    public    $show     = FALSE;

    public    $userId;

    public    $userName;

    protected $listeners = ['sickLeaveDetails' => 'open', '$refresh'];

    public function open($userId, $userName)
    {
        $this->userId   = $userId;
        $this->userName = $userName;
        $this->show     = TRUE;
    }

    public function close()
    {
        $this->show     = FALSE;
        $this->userId   = NULL;
        $this->userName = NULL;
    }

    public function render()
    {
        $sickLeaves = collect();

        if ($this->show && $this->userId) {
            $sickLeaves = SickLeave::where('user_id', $this->userId)
                ->where('year', now()->year)
                ->orderBy('start_date', 'desc')
                ->get();
        }

        $daysUsed = $sickLeaves->where('status', 'Y')->sum('days');

        return view('user::livewire.sick-leave.modal.details', [
            'sickLeaves' => $sickLeaves,
            'daysUsed'   => $daysUsed,
        ]);
    }

}