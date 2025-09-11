<?php

namespace Modules\Activity\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Entities\ActivityLog;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 10;
    public $date;

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

    public function render()
    {
        $logs = ActivityLog::query()
            ->select([
                'user_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('MIN(created_at) as first_log'),
                DB::raw('MAX(created_at) as last_log'),
                DB::raw('MAX(ip) as ip')
            ])
            ->whereDate('created_at', $this->date)
            ->groupBy('user_id')
            ->with('user')
            ->orderBy('last_log', 'desc')
            ->paginate($this->perPage);

        return view('activity::livewire.activity-list', [
            'logs' => $logs,
        ]);
    }
}