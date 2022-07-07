<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\User\Entities\User;

class UserDatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run ()
    {
        Model::unguard();
        User::create(['name' => 'Michel', 'email' => 'michel@outlook.com', 'password' => '12345']);
        User::create(['name' => 'Felipe', 'email' => 'felipe@callkruger.com', 'password' => '12345']);
        User::create(['name' => 'Test', 'email' => 'test@email.com', 'password' => '12345']);
        // $this->call("OthersTableSeeder");
    }

}
