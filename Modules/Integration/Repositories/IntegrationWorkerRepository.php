<?php

namespace Modules\Integration\Repositories;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\User;

class IntegrationWorkerRepository extends Model {

    use IntegrationRepository;

    protected $table = 'workers';

    public function user ()
    {
        return $this->belongsTo(User::class);
    }

    public function getData ()
    {
        return [
            'id'   => $this->id,
            'name' => $this->user->name,
        ];
    }

}