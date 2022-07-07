<?php

namespace Modules\Scheduling\Support\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Modules\Scheduling\Support\Facades\Timeline;

trait TimelineAttributes {

    /**
     * @var Collection;
     */
    protected static $timelineDates;

    protected static function bootTimelineAttributes ()
    {
        if ( !static::$timelineDates ) {
            static::$timelineDates = Timeline::day()->collection(30);
        }

        static::retrieved(function (Model $model) {
            $model->append(['timeline']);
            $model->mergeCasts(
                collect($model->timelineCasts)
                    ->flatMap(fn ($value, $key) => [$key => $value['cast']])
                    ->all()
            );
        });
    }

    public function getTimelineAttribute ()
    {
        return $this->getSlotCasts();
    }

    protected function getSlotCasts ()
    {
        return collect($this->timelineCasts)->flatMap(function ($value, $key) {

            $date = $this->{$key};
            $time = $date->format('H:i:s');
            $slot = static::$timelineDates->firstWhere('time', $time)['slot'];

            return [$value['name'] => ['time' => $time, 'slot' => $slot]];
        })->all();
    }

}