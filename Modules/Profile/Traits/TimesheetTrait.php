<?php

namespace Modules\Profile\Traits;

use Illuminate\Support\Carbon;

trait TimesheetTrait
{

    protected function setDaysOfWeek()
    {

        $week = config('profile.week') ?? 0;

        $startOfWeek = Carbon::now()->startOfWeek()->addWeeks($week);
        $endOfWeek = Carbon::now()->endOfWeek()->addWeeks($week);
        $period = $startOfWeek->toPeriod($endOfWeek);


        $days = collect($period)->mapWithKeys(fn ($date) => [
            $dayWeek = strtolower($date->format('l')) => [
                'day_week' => $dayWeek,
                'text' => $date->format('l M d'),
                'date' => $date->format('Y-m-d H:i'),
            ],
        ]);

        return [
            'year' => $startOfWeek->year,
            'week' => $startOfWeek->weekOfYear,
            'start' => $startOfWeek->format('l M d'),
            'end' => $endOfWeek->format('l M d'),
            'text' => [
                'start' => $startOfWeek->format('l M d'),
                'end' => $endOfWeek->format('l M d'),
            ],
            'date' => [
                'start' => $startOfWeek->format('Y-m-d H:i'),
                'end' => $endOfWeek->format('Y-m-d H:i'),
                'due_on' => $endOfWeek->next('Friday')->format('Y-m-d H:i'),
            ],
            'days' => $days
        ];
    }

    public function getDaysOfWeek()
    {
        return $this->setDaysOfWeek();
    }
}
