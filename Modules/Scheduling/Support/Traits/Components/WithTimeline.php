<?php

namespace Modules\Scheduling\Support\Traits\Components;

use Modules\Scheduling\Support\Facades\Timeline;

trait WithTimeline {

    public $timelineDate;

    public $timeline;

    public function initializeWithTimeline ()
    {
        $this->listeners = array_merge($this->listeners, [
            'changeDate'
        ]);
    }

    public function mountWithTimeline ()
    {
        $this->timelineDate = date('Y-m-d');
    }

    public function changeDate ($date)
    {
        if ( $date != $this->timelineDate ) {
            $this->timelineDate = $date;
        }
    }

    public function getTimeline ()
    {
        $timeline       = Timeline::day($this->timelineDate);
        $this->timeline = [
            'scroll'  => $timeline->scrollTime(),
            'header'  => $timeline->collection(),
            'content' => $timeline->collection(30),
        ];
    }

}