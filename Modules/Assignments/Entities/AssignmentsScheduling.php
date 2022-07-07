<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class AssignmentsScheduling extends Model {

    use HasFactory;

    protected $table         = 'assignments_scheduling';

    protected $appends       = ['schedule_date', 'start_hour', 'end_hour'];

    protected $fillable = [
        'assignment_id',
        'tech_id',
        'created_by',
        'updated_by',
        'start_date',
        'end_date',
    ];

//    protected $with          = ['tech', 'user'];

    public function assignment ()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id', 'id')->with(['status','referral','phones','job_types']);
    }

    public function user ()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function tech ()
    {
        return $this->belongsTo(User::class, 'tech_id', 'id');
    }

    public function getScheduleDateAttribute ()
    {

        $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y');

        return $return;
    }

    public function getStartHourAttribute ()
    {
        $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('g:i A');

        return $return;
    }

    public function getEndHourAttribute ()
    {
        $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('g:i A');

        return $return;
    }

    protected static function newFactory ()
    {
        return \Modules\Assignments\Database\factories\AssignmentsSchedulingFactory::new();
    }

}
