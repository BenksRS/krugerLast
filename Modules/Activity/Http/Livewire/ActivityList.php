<?php

namespace Modules\Activity\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Entities\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityList extends Component {

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public    $perPage         = 100;

    public    $date;

    public function mount()
    {
        // Inicializa com o dia atual
        $this->date = Carbon::today()->toDateString();
    }

    public function previousDay()
    {
        $this->date = Carbon::parse($this->date)->subDay()->toDateString();
        $this->resetPage();
    }

    public function nextDay()
    {
        $this->date = Carbon::parse($this->date)->addDay()->toDateString();
        $this->resetPage();
    }

    public function changeDate($direction)
    {
        $date = Carbon::parse($this->date);

        $newDate = match ($direction) {
            'prev' => $date->subDay(),
            'next' => $date->addDay(),
            default => $date,
        };

        $this->date = $newDate->toDateString();

        $this->resetPage();
    }

    public function getIsTodayProperty()
    {
        return $this->date === now()->toDateString();
    }

    public function render()
    {
        $users = [10, 25, 4, 56, 54, 118, 120, 104, 148, 145, 105, 13, 43, 102, 151];
        $logs  = ActivityLog::query()
            ->select([
                'user_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('MIN(created_at) as first_log'),
                DB::raw('MAX(created_at) as last_log'),
                DB::raw('MAX(ip) as ip')
            ])
            ->whereIn('user_id', $users)
            ->whereDate('created_at', $this->date)
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('last_log', 'desc')->get();
/*            ->paginate($this->perPage);*/

        return view('activity::livewire.activity-list', [
            'logs' => $logs,
        ]);
    }

}