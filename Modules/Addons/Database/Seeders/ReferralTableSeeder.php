<?php

namespace Modules\Addons\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Addons\Entities\Referral\Referral;
use Modules\Addons\Entities\Referral\ReferralCarrier;
use Modules\Addons\Entities\Referral\ReferralType;

class ReferralTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		Model::unguard();

		$types     = [
			['name' => 'Vendor Program', 'active' => 'Y'],
			['name' => 'Carrier', 'active' => 'Y'],
			['name' => 'Restoration', 'active' => 'Y'],
		];
		$referrals = [
			[
				'type_id'            => 1,
				'company_entity'     => 'Alacrity Group',
				'company_fictitions' => 'Alacrity',
				'street'             => '122 street',
				'city'               => 'Pompano Beach',
				'state'              => 'FL',
				'zipcode'            => '33073',
				'main_contact'       => 'Felipe',
				'email'              => 'felipe@alacrity.com',
			],
			[
				'type_id'            => 3,
				'company_entity'     => 'JOE TAYLOR',
				'company_fictitions' => 'JTR',
				'street'             => '567 street',
				'city'               => 'Boca Raton',
				'state'              => 'FL',
				'zipcode'            => '33073',
				'main_contact'       => 'JOE',
				'email'              => 'joe@jtr.com',
			],
			[
				'type_id'            => 2,
				'company_entity'     => 'UPC GROUP',
				'company_fictitions' => 'UPC Insurance',
				'street'             => '789 street',
				'city'               => 'Cocout Creeck',
				'state'              => 'FL',
				'zipcode'            => '33073',
				'main_contact'       => NULL,
				'email'              => NULL,
			],
			[
				'type_id'            => 2,
				'company_entity'     => 'Maison GROUP',
				'company_fictitions' => 'Maison Insurance',
				'street'             => '33 street',
				'city'               => 'Cocout Creeck',
				'state'              => 'FL',
				'zipcode'            => '33073',
				'main_contact'       => NULL,
				'email'              => NULL,
			],
			[
				'type_id'            => 2,
				'company_entity'     => 'St Fidelity',
				'company_fictitions' => 'St Fidelity',
				'street'             => '33 street',
				'city'               => 'orlando',
				'state'              => 'FL',
				'zipcode'            => '33073',
				'main_contact'       => NULL,
				'email'              => NULL,
			],
		];
		$carriers  = [
			['referral_id' => 1, 'carrier_id' => 5,],
			['referral_id' => 1, 'carrier_id' => 4,],
			['referral_id' => 1, 'carrier_id' => 3,],
		];

		ReferralType::upsert($types, []);
		Referral::upsert($referrals, []);
		ReferralCarrier::upsert($carriers, []);

		$this->runRelations();
	}

	protected function runRelations ()
	{
		$referral = new Referral;

		$authorizations = [
			['collect_id' => 1, 'authorization_id' => 1, 'active' => 'Y'],
			['collect_id' => 2, 'authorization_id' => 2, 'active' => 'Y'],
			['collect_id' => 3, 'authorization_id' => 3, 'active' => 'Y'],
			['collect_id' => 1, 'authorization_id' => 3, 'active' => 'Y'],
			['collect_id' => 4, 'authorization_id' => 4, 'active' => 'Y'],
			['collect_id' => 1, 'authorization_id' => 4, 'active' => 'Y'],
			['collect_id' => 1, 'authorization_id' => 5, 'active' => 'Y'],
			['collect_id' => 5, 'authorization_id' => 5, 'active' => 'Y'],
		];
		$phones         = [
			['collect_id' => 1, 'contact' => 'Felipe', 'phone' => '(954) 683-8797', 'preferred' => 'N'],
			['collect_id' => 1, 'contact' => 'Nadal', 'phone' => '(954) 999-9999', 'preferred' => 'Y']
		];

		$notes = [
			['collect_id' => 1, 'text' => 'Test'],
		];

		$referral->collection('authorizations')->sync($authorizations);
		$referral->collection('phones')->sync($phones);
		$referral->collection('notes')->sync($notes);
		/*
				$referral->phones()->makeMany($phones)->all();*/
	}

}
