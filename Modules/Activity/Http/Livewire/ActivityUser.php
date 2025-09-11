<?php

namespace Modules\Activity\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Entities\ActivityLog;

class ActivityUser extends Component {

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public    $show            = FALSE;

    public    $userId;

    public    $userName;

    public    $date;

    public    $perPage         = 20;

    protected $listeners       = ['openUserLogs' => 'loadLogs'];

    public function loadLogs($userId, $userName, $date)
    {
        $this->userId   = $userId;
        $this->userName = $userName;
        $this->date     = $date;
        $this->resetPage();
        $this->show = TRUE;
    }

    public function close()
    {
        $this->show     = FALSE;
        $this->userId   = NULL;
        $this->userName = NULL;
        $this->date     = NULL;
        $this->resetPage();
    }

    public function render()
    {
        $logs = collect();

        if ($this->show && $this->userId && $this->date) {
            $logs = ActivityLog::query()
                ->where('user_id', $this->userId)
                ->whereDate('created_at', $this->date)
                ->orderBy('created_at', 'asc')
                ->paginate($this->perPage);
        }

        return view('activity::livewire.activity-user', [
            'logs' => $logs,
        ]);
    }

}