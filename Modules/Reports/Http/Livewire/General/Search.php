<?php

namespace Modules\Reports\Http\Livewire\General;

use Livewire\Component;
use Modules\Assignments\Entities\AssignmentsJobTypes;
use Modules\Assignments\Repositories\AssignmentFinanceRepository;
use Modules\User\Entities\Workers;

class Search extends Component
{
    protected $listeners = ['search'];

    public $filter_date = 'schedulled';

    public $workers;
    public $workersSelected = [];

    public $job_types;
    public $jtSelected = [];

    public $date_from;
    public $date_to;

    public $list;

    public function mount()
    {
        $this->workers   = Workers::with('user')->where('active', 'Y')->orderBy('order')->get();
        $this->job_types = AssignmentsJobTypes::where('active', 'Y')->get();
    }

    public function updated($field)
    {
        $this->list = null;
    }

    public function clear($field)
    {
        $this->$field = [];
        $this->list   = null;
    }

    public function search()
    {
        $date_from = date('Y-m-d', strtotime($this->date_from));
        $date_to   = date('Y-m-d', strtotime($this->date_to));

        switch ($this->filter_date) {
            case 'created':
                $list = AssignmentFinanceRepository::DateCreated($date_from, $date_to)->get();
                break;
            case 'billed':
                $list = AssignmentFinanceRepository::DateBilled($date_from, $date_to)->get();
                break;
            case 'paid':
                $list = AssignmentFinanceRepository::DatePaid($date_from, $date_to)->get();
                break;
            case 'schedulled':
            default:
                $list = AssignmentFinanceRepository::DateSchedulled($date_from, $date_to)->get();
                break;
        }

        $workers = array_filter((array) $this->workersSelected);
        if (!empty($workers)) {
            $list = $list->filter(function ($assignment) use ($workers) {
                return $assignment->workers
                    ->pluck('worker_id')
                    ->intersect($workers)
                    ->isNotEmpty();
            });
        }

        // Ignora jobs cujos job types sejam apenas "no job", "trip charge" e/ou "board up"
        $ignoredJobTypes = ['no job', 'trip charge', 'board up'];
        $list = $list->filter(function ($assignment) use ($ignoredJobTypes) {
            $names = $assignment->job_types
                ->pluck('name')
                ->map(fn ($name) => strtolower(trim($name)));

            if ($names->isEmpty()) {
                return false;
            }

            return $names->diff($ignoredJobTypes)->isNotEmpty();
        });

        $jobTypes = array_filter((array) $this->jtSelected);
        if (!empty($jobTypes)) {
            $list = $list->filter(function ($assignment) use ($jobTypes) {
                return $assignment->job_types
                    ->pluck('id')
                    ->intersect($jobTypes)
                    ->isNotEmpty();
            });
        }

        $this->list = $list->values();
    }

    public function render()
    {
        return view('reports::livewire.general.search');
    }
}
