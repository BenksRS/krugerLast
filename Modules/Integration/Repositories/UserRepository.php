<?php

namespace Modules\Integration\Repositories;

use Modules\User\Entities\User;
use Illuminate\Database\Eloquent\Builder;

class UserRepository extends User
{

    use IntegrationRepository;

    protected $table = 'users';


    public function __construct()
    {
        parent::__construct();
    }

    public function getData()
    {
        return [
            'id'          => $this->id,
            'employee_id' => $this->id,
            'name'        => $this->name,
            'username'    => $this->email,
            'password'    => $this->password,
            'group'       => $this->group->name ?? 'admin',
            'active'      => $this->active,
         ];
    }

    public function notSynced()
    {
        return parent::notSynced()->where('active', 'Y');
    }
}
