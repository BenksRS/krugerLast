<?php

namespace Modules\Scheduling\Support;

use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Collection;

class Timeline {

    protected $view = 'day';

    protected $date;

    protected $scroll;

    public function __construct ()
    {
        $this->date   = date('Y-m-d');
        $this->scroll = _timeline('day.scroll') ?? '08:00:00';
    }

    public function day ($date = NULL)
    {
        $this->date = $date ?? $this->date;
        $this->view = 'day';

        return $this;
    }

    /**
     * @param int|null $interval
     *
     * @return Collection
     */
    public function collection (int $interval = NULL)
    {
        $range = $this->dateRange($interval);
        $dates = [];

        foreach ( $range as $key => $data ) {

            $slot = $key + 1;

            $collection = [
                'slot'     => $slot,
                'time'     => $data->format(_timeline('format.time')),
                'datetime' => $data->format(_timeline('format.datetime')),
                'meridiem' => [
                    'time'   => $data->format(_timeline('format.meridiem.time')),
                    'period' => $data->format(_timeline('format.meridiem.period')),
                ],
            ];
            $dates[]    = $collection;
        };

        return collect($dates);
    }

    /**
     * @return array|mixed|string
     */
    public function scrollTime ()
    {
        return $this->scroll;
    }

    /**
     * @param int|NULL $interval
     *
     * @return DatePeriod
     * @throws \Exception
     */
    protected function dateRange (int $interval = NULL)
    {
        $interval = $interval ?? _timeline("{$this->view}.interval");

        $scale = collect([
            'min'      => new DateTime($this->date . " " . _timeline("{$this->view}.min")),
            'max'      => new DateTime($this->date . " " . _timeline("{$this->view}.max")),
            'interval' => new DateInterval("PT" . $interval . "M"),
        ]);

        return new DatePeriod($scale->get('min'), $scale->get('interval'), $scale->get('max'));
    }

}