<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\JobType;

class JobTypeTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		Model::unguard();

		$jobTypes = [
			['name' => 'ROOF TARP', 'type' => 'M', 'active' => 'Y'],
			['name' => 'TARP INSPECTION', 'type' => 'S', 'active' => 'Y'],
			['name' => 'TARP REPAIR', 'type' => 'S', 'active' => 'Y'],
			['name' => 'TARP REMOVAL', 'type' => 'S', 'active' => 'Y'],
			['name' => 'WATER', 'type' => 'M', 'active' => 'Y'],
			['name' => 'DEMOLITION', 'type' => 'M', 'active' => 'Y'],
			['name' => 'LADDER ASSIST', 'type' => 'M', 'active' => 'Y'],
			['name' => 'BOARD UP', 'type' => 'M', 'active' => 'Y'],
			['name' => 'FIRE CLEAN-UP', 'type' => 'M', 'active' => 'Y'],
			['name' => 'ROOF TILE REMOVAL', 'type' => 'M', 'active' => 'Y'],
			['name' => 'TREE REMOVAL', 'type' => 'M', 'active' => 'Y'],
			['name' => 'CLEANING', 'type' => 'M', 'active' => 'Y'],
			['name' => 'COMPARATIVE', 'type' => 'S', 'active' => 'Y'],
			['name' => 'ESTIMATE', 'type' => 'M', 'active' => 'Y'],
		];

		JobType::upsert($jobTypes, []);
		// $this->call("OthersTableSeeder");
	}

}
