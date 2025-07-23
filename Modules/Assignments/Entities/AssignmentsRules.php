<?php

namespace Modules\Assignments\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;
use Modules\Referrals\Entities\Referral;

class AssignmentsRules extends Model
{
    use HasFactory;
    protected $table = 'assignments_rules';

    protected $fillable = [
        'job_type_id',
        'referral_id',
        'carrier_id',
        'tag_id',
        'note_text',
        'note_type',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'note_type' => 'array',
    ];

    protected static function newFactory ()
    {
        return \Modules\Password\Database\factories\PasswordFactory::new();
    }

    public function job_type()
    {
        return $this->belongsTo(AssignmentsJobTypes::class, 'job_type_id');
    }

    public function referral()
    {
        return $this->belongsTo(Referral::class, 'referral_id');
    }

    public function carrier()
    {
        return $this->belongsTo(Referral::class, 'carrier_id');
    }

    public function tag()
    {
        return $this->belongsTo(AssignmentsTags::class, 'tag_id');
    }

    public function user_created()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user_updated()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function boot ()
    {
        parent::boot();

        $user    = auth()->user();
        $userId = $user->id ?? 73;

        static::creating(function ( $model ) use ( $userId ) {
            $model->created_by = $userId;
            $model->updated_by = $userId;
        });

        static::updating(function ( $model ) use ( $userId ) {
            $model->updated_by = $userId;
        });
    }
}