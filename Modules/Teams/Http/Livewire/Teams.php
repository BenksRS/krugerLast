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
    public $listKey = 0;

    public function selectTeam($teamId)
    {
        $this->selectedTeamId = $teamId;
    }

    public function newTeam()
    {
        $this->selectedTeamId = null;
    }

    public function refreshList()
    {
        $this->selectedTeamId = null;
        $this->listKey++;
    }

    public function render()
    {
        return view('teams::livewire.teams');
    }
}