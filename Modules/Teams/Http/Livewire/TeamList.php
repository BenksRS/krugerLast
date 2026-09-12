<?php

namespace Modules\Teams\Http\Livewire;

use Livewire\Component;
use Modules\Teams\Entities\Team;
use Modules\User\Entities\Workers;

class TeamList extends Component
{
    public $teams;

    public function mount()
    {
        $this->loadTeams();
    }

    public function loadTeams()
    {
        $this->teams = Team::with('workers.user')->get();
    }

    public function newTeam()
    {
        $this->emitUp('newTeamRequested');
    }

    public function editTeam($teamId)
    {
        $this->emitUp('teamSelected', $teamId);
    }

    public function deleteTeam($teamId)
    {
        $team = Team::find($teamId);

        if ($team) {
            Workers::where('team_id', $teamId)
                ->get()
                ->each(function ($worker) {
                    $worker->team_id = null;
                    $worker->save();
                });

            $team->delete();
        }

        $this->loadTeams();
        $this->emitUp('teamDeleted');
    }

    public function removeWorker($workerId)
    {
        $worker = Workers::find($workerId);

        if ($worker) {
            $worker->team_id = null;
            $worker->save();
        }

        $this->loadTeams();
    }

    public function render()
    {
        return view('teams::livewire.team-list');
    }
}