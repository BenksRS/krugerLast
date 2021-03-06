<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Modules\Assignments\Entities\Assignment;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

/*	protected $appends = ['selected'];*/

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute ($value)
    {
        $this->attributes["password"] = Hash::make($value);
    }

	public function getSelectedAttribute ()
	{
		return ['Michel' => 'Michel', 'Vieira' => 'Vieira'];
	}

	public function assignment ()
	{
		return $this->belongsTo(Assignment::class, 'id', 'created_by');
	}
}
