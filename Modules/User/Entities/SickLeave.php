<?php

namespace Modules\User\Entities;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SickLeave extends Model
{
    use HasFactory;

    protected $table = 'sick_leaves';

    protected $fillable = [
        'user_id',
        'start_date',
        'days',
        'description',
        'year',
        'status',
        'b64',
        'created_by',
        'updated_by',
    ];

    protected $appends = [
        'start_date_view',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function getStartDateViewAttribute()
    {
        $return = "-";
        if ($this->start_date) {
            $return = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_date)->format('m/d/Y');
        }
        return $return;
    }

    public function setStartDateAttribute($value)
    {
        if ($value && strlen($value) === 10) {
            $value .= ' 00:00:00';
        }
        $this->attributes['start_date'] = $value;
    }

    protected static function newFactory()
    {
        return \Modules\User\Database\factories\SickLeaveFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        $user   = auth()->user();
        $userId = $user->id ?? 73;

        static::creating(function ($model) use ($userId) {
            $model->created_by = $userId;
            $model->updated_by = $userId;

            if (!$model->year && $model->start_date) {
                $model->year = Carbon::parse($model->start_date)->year;
            }
        });

        static::updating(function ($model) use ($userId) {
            $model->updated_by = $userId;
        });
    }
}