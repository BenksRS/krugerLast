<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RelatableTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		Model::unguard();

		$phones = [
			'referral' => [
				[
					'relatable_id' => 1,
					'contact'      => 'Felipe',
					'phone'        => '(954) 683-8797',
					'preferred'    => 'N',
				],
				[
					'relatable_id' => 1,
					'contact'      => 'Nadal',
					'phone'        => '(954) 999-9999',
					'preferred'    => 'Y',
				]
			]
		];

		$notes = [
			'referral' => [
				[
					'relatable_id' => 1,
					'text'         => 'Test',
				],
			]
		];

		relatable_model('phones', $phones);
		relatable_model('notes', $notes);
		// $this->call("OthersTableSeeder");
	}

}
