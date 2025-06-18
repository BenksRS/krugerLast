<?php

namespace Modules\Notes\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Entities\User;


class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'notable_id',
        'notable_type',
        'created_by',
        'type',
        'post_alacnet',
        'created_at',
        'cc_alacnet'
    ];
    protected $guarded = ['id'];
    protected $appends  = ['created_datetime'];

    public function notable()
    {
        return $this->morphTo();
    }

    public function getCreatedDatetimeAttribute ()
    {
        return date('m/d/Y g:i A', strtotime($this->created_at));
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Notes\Database\factories\NoteFactory::new();
    }
}