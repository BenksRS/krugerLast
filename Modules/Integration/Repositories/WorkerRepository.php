<?php

namespace Modules\Integration\Repositories;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WorkerRepository extends Model {

    use IntegrationRepository;

    protected $table = 'workers';

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function getData ()
    {
        return [
            'id'   => $this->user_id,
            'name' => $this->user->name,
        ];
    }



    protected static function booted()
    {
        static::addGlobalScope('workers', function (Builder $builder) {
            $builder->where('active', 'Y');
        });
    }

}