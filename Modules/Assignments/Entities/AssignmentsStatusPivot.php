<?php

namespace Modules\Assignments\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class AssignmentsStatusPivot extends Model
{
    use HasFactory;
    protected $table = 'assignments_status_pivot';
    protected $fillable = [
        'assignment_id',
        'assignment_status_id',
        'created_by',
        'description',
    ];
    protected $appends=['created_date'];

    protected $with=['status'];


    public function status()
    {
        return $this->belongsTo(AssignmentsStatus::class, 'assignment_status_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function getCreatedDateAttribute (){

        $return = "-";
        if($this->created_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format('m/d/Y g:i A');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Assignments\Database\factories\AssignmentsStatusPivotFactory::new();
    }
}
