<?php

namespace Modules\Car\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CarsChanges extends Model
{
    use HasFactory;
    protected $table    = 'cars_changes';
    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Car\Database\factories\CarsChangesFactory::new();
    }
}
