<?php

namespace Modules\Teams\Http\Livewire;

use Livewire\Component;
use Modules\Teams\Entities\Team;
use Modules\User\Entities\Workers;

class TeamSetting extends Component
{
    public $teamId;
    public $team;
    public $name;
    public $workers;
    public $selectedWorkers = [];

    public $originalName;
    public $originalSelectedWorkers = [];

    protected $rules = [
        'name' => 'required|string|max:255',
    ];

    public function mount($teamId = null)
    {
        $this->teamId = $teamId;
        $this->workers = Workers::with('user')->where('active', 'Y')->orderBy('order')->get();

        if ($this->teamId) {
            $this->team = Team::find($this->teamId);
            $this->name = $this->team->name;
            $this->selectedWorkers = Workers::where('team_id', $this->teamId)->pluck('id')->toArray();
        } else {
            $this->team = null;
            $this->name = '';
            $this->selectedWorkers = [];
        }

        $this->originalName = $this->name;
        $this->originalSelectedWorkers = $this->selectedWorkers;
    }

    public function toggleWorker($workerId)
    {
        if (in_array($workerId, $this->selectedWorkers)) {
            $this->selectedWorkers = array_values(array_diff($this->selectedWorkers, [$workerId]));
        } else {
            $this->selectedWorkers[] = $workerId;
        }
    }

    public function getIsDirtyProperty()
    {
        if ($this->name !== $this->originalName) {
            return true;
        }

        $current = collect($this->selectedWorkers)->sort()->values()->all();
        $original = collect($this->originalSelectedWorkers)->sort()->values()->all();

        return $current !== $original;
    }

    public function saveTeam()
    {
        $this->validate();

        if ($this->team) {
            $this->team->name = $this->name;
            $this->team->save();
        } else {
            $this->team = Team::create(['name' => $this->name]);
            $this->teamId = $this->team->id;
        }

        Workers::where('team_id', $this->teamId)
            ->whereNotIn('id', $this->selectedWorkers)
            ->get()
            ->each(function ($worker) {
                $worker->team_id = null;
                $worker->save();
            });

        Workers::whereIn('id', $this->selectedWorkers)
            ->get()
            ->each(function ($worker) {
                $worker->team_id = $this->teamId;
                $worker->save();
            });

        $this->originalName = $this->name;
        $this->originalSelectedWorkers = $this->selectedWorkers;

        $this->emitUp('teamSaved');
    }

    public function deleteTeam()
    {
        if ($this->team) {
            Workers::where('team_id', $this->team->id)
                ->get()
                ->each(function ($worker) {
                    $worker->team_id = null;
                    $worker->save();
                });

            $this->team->delete();
        }

        $this->emitUp('teamDeleted');
    }

    public function render()
    {
        return view('teams::livewire.team-setting');
    }
}