<?php

namespace Modules\Car\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarFile extends Model
{
    use HasFactory;

    protected $table = 'car_files';

    protected $fillable = ['car_id', 'created_by', 'updated_by', 'type', 'path'];

    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
