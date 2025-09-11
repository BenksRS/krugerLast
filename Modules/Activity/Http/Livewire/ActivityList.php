<?php

namespace Modules\Activity\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Entities\ActivityLog;
use Modules\User\Entities\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ActivityList extends Component {

    use WithPagination;

    public $perPage = 10;

    public function render()
    {
        $today = Carbon::today();
/*        $today = '2025-09-07';*/

        $logs = ActivityLog::query()
            ->select([
                'user_id',
                DB::raw('COUNT(*) as total'),
                DB::raw('MIN(created_at) as first_log'),
                DB::raw('MAX(created_at) as last_log'),
                DB::raw('MAX(ip) as ip') // pega o último IP do dia
            ])
            ->whereDate('created_at', $today)
            ->groupBy('user_id')
            ->with('user') // relacionamento com a tabela users
            ->paginate($this->perPage);

        return view('activity::livewire.activity-list', [
            'logs' => $logs,
        ]);
    }

}