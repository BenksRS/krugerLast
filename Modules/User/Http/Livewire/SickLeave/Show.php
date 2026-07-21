<?php

namespace Modules\User\Http\Livewire\SickLeave;

use Livewire\Component;
use Modules\User\Entities\User;

class Show extends Component {

    public    $search;

    protected $listeners = ['$refresh'];

    public function render()
    {
        $employees = User::where('active', 'Y')
            ->where(function($query) {
                $query->when($this->search, function($query, $search) {
                    $query->where('name', 'like', '%'.$search.'%');
                });
            })
            ->withSum(['sickLeaves as sick_days_used' => function ($query) {
                $query->where('year', now()->year)->where('status', 'Y');
            }], 'days')
            ->orderBy('name')
            ->get();

        return view('user::livewire.sick-leave.show', compact('employees'));
    }

}