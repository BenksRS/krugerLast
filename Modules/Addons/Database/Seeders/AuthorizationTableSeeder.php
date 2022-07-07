<?php

namespace Modules\Addons\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Addons\Entities\{
	Authorization
};

class AuthorizationTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		Model::unguard();

		$authorizations = [
			['name' => 'Work Authorizathion Alacrity', 'description' => '...', 'b64' => 'image wk a',],
			['name' => 'JTR', 'description' => 'jtr auth', 'b64' => 'image jtr',],
			['name' => 'upc', 'description' => 'upc work auth', 'b64' => 'image upc',],
			['name' => 'maison', 'description' => 'maison auth', 'b64' => 'image maison',],
			['name' => 'st fid', 'description' => 'st fid work auth', 'b64' => 'image st fid',],
		];

		Authorization::upsert($authorizations, []);
		// $this->call("OthersTableSeeder");
	}

}
