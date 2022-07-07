<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		$connection = get_connection();

		Schema::connection($connection)->create('referral_types', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->status('active');
			$table->timestamps();
		});

		Schema::connection($connection)->create('referrals', function (Blueprint $table) {
			$table->id();
			$table->fk('type_id', 'referral_types')->onDelete('cascade');
			$table->string('company_entity');
			$table->string('company_fictitions');
			$table->string('main_contact')->nullable();
			$table->string('email')->nullable();
			$table->address();
			$table->timestamps();
		});

		Schema::connection($connection)->create('referral_carriers', function (Blueprint $table) {
			$table->id();
			$table->fk('referral_id', 'referrals')->onDelete('cascade');
			$table->fk('carrier_id', 'referrals')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		$connection = get_connection();
		Schema::connection($connection)->dropIfExists('referral_carriers');
		Schema::connection($connection)->dropIfExists('referrals');
		Schema::connection($connection)->dropIfExists('referral_types');
	}

}
