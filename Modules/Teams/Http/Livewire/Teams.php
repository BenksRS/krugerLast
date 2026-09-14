<?php

namespace Modules\Teams\Http\Livewire;

use Livewire\Component;

class Teams extends Component
{
    protected $listeners = [
        'teamSelected' => 'selectTeam',
        'newTeamRequested' => 'newTeam',
        'teamSaved' => 'refreshList',
        'teamDeleted' => 'refreshList',
    ];

    public $selectedTeamId = null;
    public $mode = 'idle'; // idle | create | edit
    public $listKey = 0;

    public function selectTeam($teamId)
    {
        $this->selectedTeamId = $teamId;
        $this->mode = 'edit';
    }

    public function newTeam()
    {
        $this->selectedTeamId = null;
        $this->mode = 'create';
    }

    public function refreshList()
    {
        $this->selectedTeamId = null;
        $this->mode = 'idle';
        $this->listKey++;
    }

    public function render()
    {
        return view('teams::livewire.teams');
    }
}