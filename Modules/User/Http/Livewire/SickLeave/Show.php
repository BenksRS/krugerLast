<?php

namespace Modules\User\Http\Livewire\SickLeave;

use Livewire\Component;
use Modules\User\Entities\User;

class Show extends Component {

    protected $listeners = ['$refresh'];

    public function render()
    {
        $employees = User::where('active', 'Y')
            ->withSum(['sickLeaves as sick_days_used' => function ($query) {
                $query->where('year', now()->year)->where('status', 'Y');
            }], 'days')
            ->orderBy('name')
            ->get();

        return view('user::livewire.sick-leave.show', compact('employees'));
    }

}