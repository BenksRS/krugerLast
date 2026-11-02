<?php

namespace Modules\Activity\Http\Livewire;

use Carbon\Carbon;
use Livewire\Component;
use Modules\Activity\Entities\ActivityLog;

class ActivityList extends Component
{
    public $date;
    public $viewMode = 'daily';        // daily | weekly
    public $weeklyMode = 'all';        // all | individual
    public $selectedUserId = '';      // Only used for the individual weekly view

    private const USER_IDS = [
        10, 25, 4, 56, 54, 118, 120, 104, 148, 145, 105,
        13, 43, 102, 151, 171, 173, 174, 178, 181, 182,
    ];

    // Hours start at 06:00:00. Gaps of more than 60 minutes are not counted.
    private const START_TIME = '06:00:00';
    private const MAX_GAP_SECONDS = 3600;

    public function mount()
    {
        $this->date = Carbon::today()->toDateString();
    }

    public function updatedDate($value)
    {
        if (! $this->isValidDate($value)) {
            $this->date = Carbon::today()->toDateString();
        }
    }

    public function setViewMode($mode)
    {
        if (in_array($mode, ['daily', 'weekly'], true)) {
            $this->viewMode = $mode;
        }
    }

    public function updatedWeeklyMode($mode)
    {
        if (! in_array($mode, ['all', 'individual'], true)) {
            $this->weeklyMode = 'all';
        }
    }

    public function changeDate($direction)
    {
        if (! in_array($direction, ['prev', 'next'], true)) {
            return;
        }

        $date = $this->selectedDate();
        $days = $this->viewMode === 'weekly' ? 7 : 1;

        if ($direction === 'prev') {
            $date->subDays($days);
        } else {
            $date->addDays($days);
            if ($date->isFuture()) {
                $date = Carbon::today();
            }
        }

        $this->date = $date->toDateString();
    }

    public function getIsTodayProperty()
    {
        return $this->selectedDate()->isSameDay(Carbon::today());
    }

    public function getCanMoveNextProperty()
    {
        if ($this->viewMode === 'weekly') {
            return $this->selectedDate()->startOfWeek(Carbon::MONDAY)
                ->lt(Carbon::today()->startOfWeek(Carbon::MONDAY));
        }

        return $this->selectedDate()->lt(Carbon::today());
    }

    public function openDayLogs($userId, $day)
    {
        $userId = (int) $userId;
        if (! in_array($userId, self::USER_IDS, true) || ! $this->isValidDate($day)) {
            return;
        }

        [$start, $end] = $this->dateRange();
        $target = Carbon::parse($day);
        if ($target->lt($start) || $target->gt($end)) {
            return;
        }

        $log = ActivityLog::query()->with('user')
            ->where('user_id', $userId)->first();
        $name = $log && $log->user ? $log->user->name : 'User #' . $userId;

        // Keep the existing ActivityUser modal unchanged.
        $this->emit('openUserLogs', $userId, $name, $target->toDateString());
    }

    private function isValidDate($date)
    {
        if (! is_string($date) || ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            return false;
        }

        try {
            return Carbon::createFromFormat('!Y-m-d', $date)->format('Y-m-d') === $date;
        } catch (\Throwable $e) {
            return false;
        }
    }

    private function selectedDate()
    {
        return Carbon::parse($this->isValidDate($this->date)
            ? $this->date : Carbon::today()->toDateString())->startOfDay();
    }

    private function dateRange()
    {
        $date = $this->selectedDate();
        if ($this->viewMode === 'weekly') {
            return [
                $date->copy()->startOfWeek(Carbon::MONDAY)->startOfDay(),
                $date->copy()->endOfWeek(Carbon::SUNDAY)->endOfDay(),
            ];
        }

        return [$date->copy()->startOfDay(), $date->copy()->endOfDay()];
    }

    private function listUsers()
    {
        // User model namespace is not assumed: use the existing ActivityLog->user relation.
        return ActivityLog::query()
            ->select('user_id')->distinct()->with('user')
            ->whereIn('user_id', self::USER_IDS)->get()
            ->mapWithKeys(function ($log) {
                return [(int) $log->user_id => optional($log->user)->name
                    ?: 'User #' . $log->user_id];
            })->sort(SORT_NATURAL | SORT_FLAG_CASE)->all();
    }

    private function queryLogs(Carbon $start, Carbon $end, $selectedUserId = null)
    {
        $query = ActivityLog::query()->with('user')
            ->whereIn('user_id', self::USER_IDS)
            ->whereBetween('created_at', [
                $start->toDateTimeString(), $end->toDateTimeString(),
            ]);

        if ($selectedUserId !== null) {
            $query->where('user_id', (int) $selectedUserId);
        }

        return $query->orderBy('user_id')->orderBy('created_at')->get();
    }

    // This method is the ONLY source of the daily hours used by the UI and export.
    private function summarizeLogs($logs)
    {
        $days = [];

        foreach ($logs as $log) {
            $userId = (int) $log->user_id;
            $time = Carbon::parse($log->created_at);
            $dayKey = $time->toDateString();
            $key = $userId . ':' . $dayKey;

            if (! isset($days[$key])) {
                $days[$key] = [
                    'user_id' => $userId,
                    'user_name' => optional($log->user)->name ?: 'User #' . $userId,
                    'date' => $dayKey,
                    'total' => 0,
                    'first_log' => null,
                    'last_log' => null,
                    'ip' => null,
                    'seconds' => 0,
                    'previous_at' => null,
                ];
            }

            $row = &$days[$key];
            $row['total']++;
            $row['ip'] = $log->ip ?: $row['ip'];

            // Raw records before 06:00 remain accessible in ActivityUser (audit).
            if ($time->format('H:i:s') < self::START_TIME) {
                unset($row);
                continue;
            }

            // A day only starts when a real login event occurs at/after 06:00.
            if ($row['first_log'] === null) {
                if ($log->event === 'login') {
                    $row['first_log'] = $time->toDateTimeString();
                    $row['last_log'] = $time->toDateTimeString();
                    $row['previous_at'] = $time;
                }
                unset($row);
                continue;
            }

            $elapsed = $row['previous_at']->diffInSeconds($time);
            if ($elapsed <= self::MAX_GAP_SECONDS) {
                $row['seconds'] += $elapsed;
            }

            // Resume counting after each log even if the previous gap was ignored.
            $row['last_log'] = $time->toDateTimeString();
            $row['previous_at'] = $time;
            unset($row);
        }

        foreach ($days as &$row) {
            unset($row['previous_at']);
            $row['hours'] = $row['first_log'] !== null
                ? $this->formatHours($row['seconds']) : 'N/A';
        }
        unset($row);

        return array_values($days);
    }

    private function formatHours($seconds)
    {
        $minutes = intdiv((int) $seconds, 60);
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
    }

    private function reportData()
    {
        [$start, $end] = $this->dateRange();
        $users = $this->listUsers();
        $weekly = $this->viewMode === 'weekly';

        $selectedUserId = $weekly && $this->weeklyMode === 'individual'
                          && ctype_digit((string) $this->selectedUserId)
                          && isset($users[(int) $this->selectedUserId])
            ? (int) $this->selectedUserId : null;

        // If no user was chosen, individual view will display a selection prompt.
        $missingUser = $weekly && $this->weeklyMode === 'individual'
                       && $selectedUserId === null;

        $dailyRows = $missingUser ? [] : $this->summarizeLogs(
            $this->queryLogs($start, $end, $selectedUserId)
        );

        // Daily report: keep only users who have at least one log that day.
        if (! $weekly) {
            usort($dailyRows, function ($a, $b) {
                return strcmp($b['last_log'] ?: '', $a['last_log'] ?: '');
            });
            return compact('start', 'end', 'users', 'dailyRows') + [
                    'weeklyRows' => [], 'weekDays' => [], 'missingUser' => false,
                ];
        }

        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDays[] = $start->copy()->addDays($i)->toDateString();
        }

        // Show all configured users, including those with no activity during the week.
        $weeklyRows = [];
        foreach ($users as $userId => $name) {
            if ($selectedUserId !== null && $selectedUserId !== (int) $userId) {
                continue;
            }
            $weeklyRows[$userId] = [
                'user_id' => $userId,
                'user_name' => $name,
                'days' => array_fill_keys($weekDays, null),
                'seconds' => 0,
                'hours' => '00:00',
            ];
        }

        foreach ($dailyRows as $row) {
            $id = $row['user_id'];
            if (isset($weeklyRows[$id])) {
                $weeklyRows[$id]['days'][$row['date']] = $row;
                if ($row['first_log'] !== null) {
                    $weeklyRows[$id]['seconds'] += $row['seconds'];
                }
            }
        }

        foreach ($weeklyRows as &$row) {
            $row['hours'] = $this->formatHours($row['seconds']);
        }
        unset($row);

        return compact('start', 'end', 'users', 'dailyRows', 'weeklyRows', 'weekDays', 'missingUser');
    }

    // One button/dropdown, two exports: displayed summary and original detailed events.
    public function exportCsv($type = 'summary')
    {
        if (! in_array($type, ['summary', 'details'], true)) {
            return;
        }

        $data = $this->reportData();
        if ($data['missingUser']) {
            session()->flash('activityExportError', 'Select a user before exporting.');
            return;
        }

        $start = $data['start'];
        $end = $data['end'];
        $mode = $this->viewMode === 'weekly' ? 'weekly' : 'daily';
        $filename = 'activity-' . $mode . '-' . $type . '-'
                    . $start->format('Ymd') . '-' . $end->format('Ymd') . '.csv';

        $userId = $this->viewMode === 'weekly' && $this->weeklyMode === 'individual'
            ? (int) $this->selectedUserId : null;

        return response()->streamDownload(function () use ($type, $data, $start, $end, $userId) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF"); // Excel UTF-8 BOM
            fwrite($out, "sep=;\r\n");   // Recognized by Excel as the CSV delimiter

            if ($type === 'details') {
                $this->writeCsvRow($out, ['User', 'Event', 'URL', 'IP', 'Date']);

                // Chunk rather than load the entire history into memory.
                $query = ActivityLog::query()->with('user')
                    ->whereIn('user_id', self::USER_IDS)
                    ->whereBetween('created_at', [
                        $start->toDateTimeString(), $end->toDateTimeString(),
                    ]);
                if ($userId !== null) {
                    $query->where('user_id', $userId);
                }
                $query->orderBy('created_at')->orderBy('id')
                    ->chunk(500, function ($logs) use ($out) {
                        foreach ($logs as $log) {
                            $this->writeCsvRow($out, [
                                optional($log->user)->name ?: 'User #' . $log->user_id,
                                $log->event, $log->url, $log->ip,
                                Carbon::parse($log->created_at)->format('m/d/Y H:i:s'),
                            ]);
                        }
                    });
                fclose($out);
                return;
            }

            if ($this->viewMode !== 'weekly') {
                $this->writeCsvRow($out, [
                    'User', 'Logs', 'First Log', 'Last Log', 'Total Hours', 'IP',
                ]);
                foreach ($data['dailyRows'] as $row) {
                    $this->writeCsvRow($out, [
                        $row['user_name'], $row['total'],
                        $this->formatDateTime($row['first_log']),
                        $this->formatDateTime($row['last_log']),
                        $row['hours'], $row['ip'],
                    ]);
                }
            } elseif ($this->weeklyMode === 'individual') {
                $this->writeCsvRow($out, ['User', 'Date', 'Day', 'Total Hours']);
                foreach ($data['weeklyRows'] as $row) {
                    foreach ($data['weekDays'] as $day) {
                        $record = $row['days'][$day];
                        $this->writeCsvRow($out, [
                            $row['user_name'], Carbon::parse($day)->format('m/d/Y'),
                            Carbon::parse($day)->format('l'),
                            $record ? $record['hours'] : '—',
                        ]);
                    }
                    $this->writeCsvRow($out, [$row['user_name'], '', 'Weekly Total', $row['hours']]);
                }
            } else {
                $headers = ['User'];
                foreach ($data['weekDays'] as $day) {
                    $headers[] = Carbon::parse($day)->format('D m/d');
                }
                $headers[] = 'Weekly Total';
                $this->writeCsvRow($out, $headers);

                foreach ($data['weeklyRows'] as $row) {
                    $cells = [$row['user_name']];
                    foreach ($data['weekDays'] as $day) {
                        $record = $row['days'][$day];
                        $cells[] = $record ? $record['hours'] : '—';
                    }
                    $cells[] = $row['hours'];
                    $this->writeCsvRow($out, $cells);
                }
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function formatDateTime($date)
    {
        return $date ? Carbon::parse($date)->format('m/d/Y H:i:s') : 'N/A';
    }

    private function writeCsvRow($stream, $cells)
    {
        // Prevent Excel/Sheets from evaluating untrusted strings as formulas.
        $cells = array_map(function ($value) {
            if ($value === null) {
                return '';
            }
            $value = (string) $value;
            if (preg_match('/^[\s]*[=+@\-]/u', $value)) {
                return "'" . $value;
            }
            return $value;
        }, $cells);
        fputcsv($stream, $cells, ';');
    }

    public function render()
    {
        return view('activity::livewire.activity-list', $this->reportData());
    }
}