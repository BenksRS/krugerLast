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
    // Entries before 06:00 are not considered for any hour calculation.
    private const HOURS_START = '06:00:00';

    // An interval strictly greater than one hour counts as idle time in full.
    private const MAX_LOG_GAP_SECONDS = 3600;

    private const TRACKED_USER_IDS = [
        10, 25, 4, 56, 54, 118, 120, 104, 148, 145, 105,
        13, 43, 102, 151, 171, 173, 174, 178, 181, 182
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

    /**
     * Calculate effective logged hours per user and calendar date.
     *
     * Business rules:
     * - Only events occurring from 06:00:00 through 23:59:59 are eligible.
     * - The clock begins with the first `login` event at/after 06:00.
     * - For each pair of consecutive events after that login, count the
     *   elapsed seconds ONLY if the gap is <= 60 minutes. If the gap is
     *   longer than 60 minutes, exclude the ENTIRE gap.
     * - Never carry hours or a previous event over to the next calendar day.
     * - Return null if no qualifying login was found on that date.
     *
     * Read events as a cursor to avoid loading an entire week's raw event
     * records into memory. Use the same calculation for daily and weekly.
     *
     * @return array<int, array<string, int|null>>
     */
    private function calculateDailyMinutes(Carbon $start, Carbon $end): array
    {
        $activityByDay = [];

        $records = ActivityLog::query()
            ->select(['user_id', 'event', 'created_at'])
            ->whereIn('user_id', self::TRACKED_USER_IDS)
            ->whereBetween('created_at', [
                $start->copy()->startOfDay(),
                $end->copy()->endOfDay(),
            ])
            ->whereTime('created_at', '>=', self::HOURS_START)
            ->orderBy('user_id')
            ->orderBy('created_at')
            ->cursor();

        foreach ($records as $record) {
            $userId = (int) $record->user_id;
            $timestamp = Carbon::parse($record->created_at);
            $date = $timestamp->toDateString();

            if (!isset($activityByDay[$userId][$date])) {
                $activityByDay[$userId][$date] = [
                    'previous_at' => null,
                    'seconds' => 0,
                ];
            }

            $daily = &$activityByDay[$userId][$date];

            // A user must have a qualifying login to start the daily clock.
            if ($daily['previous_at'] === null) {
                if (strcasecmp((string) $record->event, 'login') === 0) {
                    $daily['previous_at'] = $timestamp;
                }
                unset($daily);
                continue;
            }

            $gapSeconds = (int) $daily['previous_at']->diffInSeconds($timestamp);

            // Do not just subtract the excess: exclude the whole idle gap.
            if ($gapSeconds <= self::MAX_LOG_GAP_SECONDS) {
                $daily['seconds'] += $gapSeconds;
            }

            // Resume counting from this event for subsequent short gaps.
            $daily['previous_at'] = $timestamp;
            unset($daily);
        }

        $minutesByDay = [];
        foreach ($activityByDay as $userId => $dates) {
            foreach ($dates as $date => $daily) {
                $minutesByDay[$userId][$date] = $daily['previous_at'] === null
                    ? null
                    : intdiv($daily['seconds'], 60);
            }
        }

        return $minutesByDay;
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
            // Preserve the raw daily log count, while constraining first login and calculated hours.
            $logs = ActivityLog::query()
                ->select([
                    'user_id',
                    DB::raw('COUNT(*) as total'),
                    DB::raw("MIN(CASE WHEN event = 'login' AND TIME(created_at) >= '" . self::HOURS_START . "' THEN created_at END) as first_log"),
                    DB::raw('MAX(created_at) as last_log'),
                    DB::raw('MAX(ip) as ip'),
                ])
                ->whereIn('user_id', self::TRACKED_USER_IDS)
                ->whereDate('created_at', $this->date)
                ->groupBy('user_id')
                ->with('user')
                ->orderBy('last_log', 'desc')
                ->get();

            $dailyMinutes = $this->calculateDailyMinutes(
                Carbon::parse($this->date),
                Carbon::parse($this->date)
            );

            foreach ($logs as $log) {
                $log->worked_minutes = $dailyMinutes[(int) $log->user_id][$this->date] ?? null;
            }
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

            // Preserve raw log counts in the weekly views. The hours calculation
            // below ignores pre-06:00 records and long inactive intervals.
            $dailyLogs = ActivityLog::query()
                ->select([
                    'user_id',
                    DB::raw('DATE(created_at) as log_date'),
                    DB::raw('COUNT(*) as log_count'),
                ])
                ->whereIn('user_id', self::TRACKED_USER_IDS)
                ->whereBetween('created_at', [
                    $weekStart->copy()->startOfDay(),
                    $weekEnd->copy()->endOfDay(),
                ])
                ->groupBy('user_id', DB::raw('DATE(created_at)'))
                ->get();

            $dailyMinutes = $this->calculateDailyMinutes($weekStart, $weekEnd);
            $dailyLookup = [];

            foreach ($dailyLogs as $dailyLog) {
                $userId = (int) $dailyLog->user_id;
                $logDate = $dailyLog->log_date;

                $dailyLookup[$userId][$logDate] = [
                    'minutes' => $dailyMinutes[$userId][$logDate] ?? null,
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