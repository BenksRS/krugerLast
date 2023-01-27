<?php

namespace Modules\Car\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;

class CarsLogs extends Model
{
    use HasFactory;
    protected $table    = 'cars_logs';
    protected $fillable = [
        'car_id',
        'miles',
        'check_oil',
        'check_oil_filter',
        'check_fuel_filter',
        'check_air_filter',
        'check_break',
        'check_windshield',
        'check_tire_pressure',
        'check_front_tires',
        'check_rear_tires',
        'changes',
        'date',
        'created_by',
        'updated_by',
        'text'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function edited()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }
    protected static function newFactory()
    {
        return \Modules\Car\Database\factories\CarsLogsFactory::new();
    }
}
