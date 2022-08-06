<?php

namespace Modules\Employees\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class EmployeeTimesheet extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'created_by', 'updated_by', 'approved_by', 'week', 'year', 'start_date', 'end_date', 'due_on', 'status', 'approved_at'];
    protected $appends = [
        'due_on_view',
        'approved_view',
        'start_md',
        'end_md'
    ];
    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    public function user_approved()
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }
    public function getApprovedViewAttribute(){

        $return = "-";
        if($this->approved_at){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->approved_at)->format('m/d/Y');
        }
        return $return;
    }
    public function getDueOnViewAttribute(){

        $return = "-";
        if($this->due_on){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->due_on)->format('m/d/Y');
        }
        return $return;
    }
    public function getStartMdAttribute(){

        $return = "-";
        if($this->start_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d');
        }
        return $return;
    }
    public function getEndMdAttribute (){

        $return = "-";
        if($this->end_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_date)->format('m/d');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeTimesheetFactory::new();
    }
}
