<?php

namespace Modules\Integration\Repositories;

use Modules\User\Entities\User;

class UserRepository extends User {

    use IntegrationRepository;

    protected $table = 'users';

    public function resources ()
    {
        return [
            'id'          => $this->id,
            'group'       => $this->group,
            'name'        => $this->name,
            'username'    => $this->email,
            'password'    => $this->password,
            'employee_id' => $this->id_employee,
        ];
    }

}