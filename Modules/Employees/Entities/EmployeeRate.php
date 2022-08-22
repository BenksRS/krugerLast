<?php

namespace Modules\Employees\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeRate extends Model
{
    use HasFactory;
    protected $table    = 'employee_rates';
    protected $fillable = [
        'user_id',
        'type',
        'regular_day',
        'weekend_day',
        'sleep_out',
        'hurricane',
        'oncall',
    ];
    protected $appends = [
        'type_name'
        ];

    public function getTypeNameAttribute (){
        switch ($this->type){
            case 'D':
                $info = "Day";
                break;
            case 'H':
                $info = "Hour";
                break;
            case 'S':
                $info = "Salary";
                break;
        }
        return $info;
    }
    protected static function newFactory()
    {
        return \Modules\Employees\Database\factories\EmployeeRateFactory::new();
    }
}
