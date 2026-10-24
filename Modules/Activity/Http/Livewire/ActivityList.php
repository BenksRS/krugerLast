<?php

namespace Modules\Activity\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Activity\Entities\ActivityLog;

class ActivityList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $perPage = 100;

    // Preserve the same users included in the original daily report.
    private const TRACKED_USER_IDS = [
        10, 25, 4, 56, 54, 118, 120, 104, 148, 145, 105,
        13, 43, 102, 151, 171, 173, 174, 178, 181, 182,
    ];

    public $date;
    public $weekDate;
    public $mode = 'daily'; // 'daily' or 'weekly'
    public $weeklyView = 'all'; // 'all' or 'individual'
    public $selectedUserId = '';

    public function mount()
    {
        $this->date = Carbon::today()->toDateString();
        $this->weekDate = $this->date;
    }

    public function setMode($mode)
    {
        if (in_array($mode, ['daily', 'weekly'], true)) {
            $this->mode = $mode;
        }
    }

    public function setWeeklyView($view)
    {
        if (in_array($view, ['all', 'individual'], true)) {
            $this->weeklyView = $view;
        }
    }

    // Backwards-compatible wrappers kept for existing Livewire consumers.
    public function previousDay()
    {
        $this->changeDate('prev');
    }

    public function nextDay()
    {
        $this->changeDate('next');
    }

    public function changeDate($direction)
    {
        if (!in_array($direction, ['prev', 'next'], true)) {
            return;
        }

        $selected = Carbon::parse($this->date);

        if ($direction === 'next' && $selected->isToday()) {
            return;
        }

        $this->date = $selected
            ->addDays($direction === 'next' ? 1 : -1)
            ->toDateString();
        $this->resetPage();
    }

    public function changeWeek($direction)
    {
        if (!in_array($direction, ['prev', 'next'], true)) {
            return;
        }

        $start = Carbon::parse($this->weekDate)->startOfWeek(Carbon::MONDAY);

        if ($direction === 'next' && $start->greaterThanOrEqualTo(Carbon::today()->startOfWeek(Carbon::MONDAY))) {
            return;
        }

        $this->weekDate = $start
            ->addWeeks($direction === 'next' ? 1 : -1)
            ->toDateString();
    }

    public function updatedWeekDate($value)
    {
        // The date input is only a week selector; cap future dates at today.
        try {
            $selected = Carbon::createFromFormat('!Y-m-d', $value);
            if (!$selected || $selected->format('Y-m-d') !== $value) {
                throw new \InvalidArgumentException('Invalid date');
            }
            $this->weekDate = $selected->greaterThan(Carbon::today())
                ? Carbon::today()->toDateString()
                : $selected->toDateString();
        } catch (\Exception $e) {
            $this->weekDate = Carbon::today()->toDateString();
        }
    }

    public function getIsTodayProperty()
    {
        return $this->date === Carbon::today()->toDateString();
    }

    public function getIsCurrentWeekProperty()
    {
        return Carbon::parse($this->weekDate)
            ->startOfWeek(Carbon::MONDAY)
            ->greaterThanOrEqualTo(Carbon::today()->startOfWeek(Carbon::MONDAY));
    }

    /**
     * Opens the existing daily log modal, including from a weekly table cell.
     * Resolve the user name on the server so it never needs HTML/JS escaping.
     */
    public function showUserLogs($userId, $date)
    {
        $userId = (int) $userId;

        if (!in_array($userId, self::TRACKED_USER_IDS, true)) {
            return;
        }

        try {
            $day = Carbon::createFromFormat('!Y-m-d', $date);
            if (!$day || $day->format('Y-m-d') !== $date) {
                return;
            }
        } catch (\Exception $e) {
            return;
        }

        $firstActivity = ActivityLog::query()
            ->where('user_id', $userId)
            ->with('user')
            ->first();

        $name = optional(optional($firstActivity)->user)->name ?? 'N/A';

        $this->emit('openUserLogs', $userId, $name, $date);
    }

    private function formatMinutes($minutes)
    {
        $minutes = max(0, (int) $minutes);
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }

    public function render()
    {
        $logs = collect();
        $weekDays = [];
        $weeklyRows = collect();
        $userOptions = collect();
        $selectedWeeklyRow = null;

        $weekStart = Carbon::parse($this->weekDate)->startOfWeek(Carbon::MONDAY);
        $weekEnd = $weekStart->copy()->endOfWeek(Carbon::SUNDAY);

        if ($this->mode === 'daily') {
            // Keep the existing daily view and its calculation unchanged.
            $logs = ActivityLog::query()
                ->select([
                    'user_id',
                    DB::raw('COUNT(*) as total'),
                    DB::raw("MIN(CASE WHEN event = 'login' THEN created_at END) as first_log"),
                    DB::raw('MAX(created_at) as last_log'),
                    DB::raw('MAX(ip) as ip'),
                ])
                ->whereIn('user_id', self::TRACKED_USER_IDS)
                ->whereDate('created_at', $this->date)
                ->groupBy('user_id')
                ->with('user')
                ->orderBy('last_log', 'desc')
                ->get();
        } else {
            // Every tracked user with at least one historical activity record
            // remains available in the dropdown, even when absent this week.
            $userOptions = ActivityLog::query()
                ->select('user_id')
                ->whereIn('user_id', self::TRACKED_USER_IDS)
                ->groupBy('user_id')
                ->with('user')
                ->get()
                ->map(function ($activity) {
                    return [
                        'id' => (int) $activity->user_id,
                        'name' => optional($activity->user)->name ?? 'User #' . $activity->user_id,
                    ];
                })
                ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
                ->values();

            for ($dayOffset = 0; $dayOffset < 7; $dayOffset++) {
                $day = $weekStart->copy()->addDays($dayOffset);
                $weekDays[] = [
                    'date' => $day->toDateString(),
                    'label' => $day->format('D'),
                    'shortDate' => $day->format('m/d'),
                    'fullDate' => $day->format('m/d/Y'),
                ];
            }

            // Only one grouped query for all seven days and all users.
            // Same semantics as the daily report: first *login* -> last event.
            $dailyLogs = ActivityLog::query()
                ->select([
                    'user_id',
                    DB::raw('DATE(created_at) as log_date'),
                    DB::raw('COUNT(*) as log_count'),
                    DB::raw("MIN(CASE WHEN event = 'login' THEN created_at END) as first_log"),
                    DB::raw('MAX(created_at) as last_log'),
                ])
                ->whereIn('user_id', self::TRACKED_USER_IDS)
                ->whereBetween('created_at', [
                    $weekStart->copy()->startOfDay(),
                    $weekEnd->copy()->endOfDay(),
                ])
                ->groupBy('user_id', DB::raw('DATE(created_at)'))
                ->get();

            $dailyLookup = [];

            foreach ($dailyLogs as $dailyLog) {
                $minutes = $dailyLog->first_log
                    ? Carbon::parse($dailyLog->first_log)
                        ->diffInMinutes(Carbon::parse($dailyLog->last_log))
                    : null;

                $dailyLookup[(int) $dailyLog->user_id][$dailyLog->log_date] = [
                    'minutes' => $minutes,
                    'logCount' => (int) $dailyLog->log_count,
                ];
            }

            $weeklyRows = $userOptions->map(function ($user) use ($weekDays, $dailyLookup) {
                $days = [];
                $totalMinutes = 0;
                $daysWithLogs = 0;
                $incompleteDays = 0;

                foreach ($weekDays as $weekDay) {
                    $data = $dailyLookup[$user['id']][$weekDay['date']] ?? null;
                    $minutes = $data['minutes'] ?? null;
                    $hasLogs = $data !== null;

                    if ($hasLogs) {
                        $daysWithLogs++;
                        if ($minutes === null) {
                            $incompleteDays++;
                        } else {
                            $totalMinutes += $minutes;
                        }
                    }

                    $days[] = [
                        'date' => $weekDay['date'],
                        'label' => $weekDay['label'],
                        'fullDate' => $weekDay['fullDate'],
                        'hasLogs' => $hasLogs,
                        'logCount' => $data['logCount'] ?? 0,
                        'hours' => $minutes === null
                            ? ($hasLogs ? 'N/A' : '—')
                            : $this->formatMinutes($minutes),
                    ];
                }

                return [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'days' => $days,
                    'daysWithLogs' => $daysWithLogs,
                    'incompleteDays' => $incompleteDays,
                    'totalMinutes' => $totalMinutes,
                    'totalHours' => $this->formatMinutes($totalMinutes),
                ];
            });

            $selectedWeeklyRow = $weeklyRows->firstWhere('id', (int) $this->selectedUserId);
        }

        return view('activity::livewire.activity-list', [
            'logs' => $logs,
            'weekStart' => $weekStart,
            'weekEnd' => $weekEnd,
            'weekDays' => $weekDays,
            'weeklyRows' => $weeklyRows,
            'userOptions' => $userOptions,
            'selectedWeeklyRow' => $selectedWeeklyRow,
        ]);
    }
}