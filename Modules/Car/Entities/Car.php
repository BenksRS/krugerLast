<?php

namespace Modules\Car\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notes\Entities\Note;

class Car extends Model
{

    use HasFactory;
    protected $table    = 'cars';
    protected $fillable = [
        'auto',
        'make',
        'year',
        'plate',
        'epass',
        'vin',
        'loan_number',
        'loan_monthly_amount',
        'loan_times',
        'loan_start_date',
        'down_payment',
        'depreciacion_year',
        'insurance_expires',
        'insurance_policy',
        'insurance_amount_monthly',
        'tag_expires',
        'driver',
        'fuel_autonomy',
        'notes_old',
        'updated_at',
        'created_at',
    ];

    public function notes ()
    {
        return $this->morphMany(Note::class, 'notable')->orderBy('id', 'DESC');
    }

    protected static function newFactory()
    {
        return \Modules\Car\Database\factories\CarFactory::new();
    }
}
