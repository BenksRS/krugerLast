<?php

namespace Modules\Integration\Repositories;

use Modules\User\Entities\User;

class IntegrationUserRepository extends User {

    use IntegrationRepository;

    protected $table = 'users';

    public function getData ()
    {
        return [
            'id'          => $this->id,
            'employee_id' => $this->id,
            'name'        => $this->name,
            'username'    => $this->email,
            'password'    => $this->password,
            'group'       => 'admin',
        ];
    }

}