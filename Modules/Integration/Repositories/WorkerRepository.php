<?php

namespace Modules\Integration\Repositories;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Model;

class WorkerRepository extends Model
{

    use IntegrationRepository;

    protected $table = 'workers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getData()
    {
        return [
            'id'   => $this->user_id,
            'name' => $this->user->name,
            'active' => $this->active,
        ];
    }

    public function notSynced()
    {
        return parent::notSynced()->where('active', 'Y');
    }
}
