<?php

namespace Modules\Employees\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class EmployeeInfo extends Model
{
    use HasFactory;
    protected $table    = 'employee_info';
    protected $fillable = [
        'user_id',
        'full_name',
        'dob',
        'start_date',
        'phone'
    ];


    protected $appends = [
        'start_date_view',
        'dob_view',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getStartDateViewAttribute (){

        $return = "-";
        if($this->start_date){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y');
        }
        return $return;
    }
    public function getDobViewAttribute (){

        $return = "-";
        if($this->dob){
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->dob)->format('m/d/Y');
        }
        return $return;
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeInfoFactory::new();
    }
}
