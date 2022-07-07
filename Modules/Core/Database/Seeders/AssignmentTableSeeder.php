<?php

namespace Modules\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\Assignment\{Assignment, AssignmentJobType, AssignmentStatus, AssignmentStatusLog, AssignmentScheduling, AssignmentAuthorization};

class AssignmentTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run ()
	{
		Model::unguard();

		$assignments = [
			[
				'referral_id'  => 1,
				'carrier_id'   => 4,
				'carrier'      => NULL,
				'first_name'   => 'MICHELLE',
				'last_name'    => 'RIVERA',
				'email'        => 'test@test.com',
				'claim_number' => '3300386587',
				/*				'infos'        => [],*/
				'street'       => '5407 SW 115th Street Road',
				'city'         => 'Ocala',
				'state'        => 'FL',
				'zipcode'      => '34476',
				'created_by'   => 1,
				'updated_by'   => 2,
				'loss_at'      => '2021-10-05 15:00:00',
				'assigned_at'  => '2021-10-12 13:00:00',
			],
			[
				'referral_id'  => 2,
				'carrier_id'   => NULL,
				'carrier'      => 'FED NAT',
				'first_name'   => 'Robert',
				'last_name'    => 'Rueb',
				'email'        => 'test@test.com',
				'claim_number' => 'HO0520330629',
				/*				'infos'        => [],*/
				'street'       => '1040 Wonderwood Ct',
				'city'         => 'Pensacola',
				'state'        => 'FL',
				'zipcode'      => '32514',
				'created_by'   => 2,
				'updated_by'   => 3,
				'loss_at'      => '2021-10-05 15:00:00',
				'assigned_at'  => '2021-10-12 13:00:00',
			],
		];

		Assignment::upsert($assignments, []);

		$this->jobTypeSeeder();
		$this->statusSeeder();
		$this->scheduleSeeder();
		$this->authorizationSeeder();
		$this->relatableSeeder();
	}

	protected function jobTypeSeeder ()
	{
		$jobTypes = [
			[
				'assignment_id' => 1,
				'job_type_id'   => 1,
			],
			[
				'assignment_id' => 1,
				'job_type_id'   => 14,
			],
			[
				'assignment_id' => 2,
				'job_type_id'   => 1,
			],
			[
				'assignment_id' => 2,
				'job_type_id'   => 11,
			],
		];

		AssignmentJobType::upsert($jobTypes, []);
	}

	protected function statusSeeder ()
	{
		$status = [
			['name' => 'OPEN', 'active' => 'Y', 'ordem' => '1'],
			['name' => 'IN PPROGRESS', 'active' => 'Y', 'ordem' => '30'],
			['name' => 'SCHEDULED', 'active' => 'Y', 'ordem' => '20'],
			['name' => 'PENDING', 'active' => 'Y', 'ordem' => '10'],
		];

		$status_logs = [
			['assignment_id' => 1, 'status_id' => 1, 'created_by' => 3],
			['assignment_id' => 1, 'status_id' => 3, 'created_by' => 3],
			['assignment_id' => 1, 'status_id' => 2, 'created_by' => 2],
			['assignment_id' => 2, 'status_id' => 1, 'created_by' => 1],
			['assignment_id' => 2, 'status_id' => 4, 'created_by' => 2],

		];

		AssignmentStatus::upsert($status, []);
		AssignmentStatusLog::upsert($status_logs, []);
	}

	protected function scheduleSeeder ()
	{
		$schedulings = [
			[
				'assignment_id' => 1,
				'tech_id'       => 2,
				'created_by'    => 2,
				'updated_by'    => 3,
				'started_at'    => '2021-10-20 10:00:00',
				'ended_at'      => '2021-10-20 11:00:00',
			],
		];

		AssignmentScheduling::upsert($schedulings, []);
	}

	protected function authorizationSeeder ()
	{
		$authorizations = [
			['assignment_id' => 1, 'authorization_id' => 2],
			['assignment_id' => 1, 'authorization_id' => 5],
		];

		AssignmentAuthorization::upsert($authorizations, []);
	}

	protected function relatableSeeder ()
	{
		$tags = [
			['name' => 'SINGLE STORY'],
			['name' => 'TWO STORY'],
			['name' => 'STEEP ROOF'],
		];

		$events = [
			['name' => 'Hurricane IDA'],
		];
	}

}
