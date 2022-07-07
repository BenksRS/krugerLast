<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		$connection = get_connection();

		Schema::connection($connection)->create('assignments', function (Blueprint $table) {
			$table->id();
			$table->fk('referral_id', 'referrals')->onDelete('cascade');
			$table->unsignedBigInteger('carrier_id')->nullable();
			$table->string('carrier')->nullable();
			$table->string('first_name')->nullable();
			$table->string('last_name')->nullable();
			$table->string('email')->nullable();
			$table->string('claim_number')->nullable();
			$table->json('infos')->nullable();
			$table->address();
			$table->by(['created_by', 'updated_by']);
			$table->at(['loss_at', 'assigned_at']);
			$table->timestamps();
		});

		Schema::connection($connection)->create('assignment_schedules', function (Blueprint $table) {
			$table->id();
			$table->fk('assignment_id', 'assignments')->onDelete('cascade');
			$table->by('tech_id');
			$table->by(['created_by', 'updated_by']);
			$table->at(['started_at', 'ended_at']);
			$table->timestamps();
		});

		Schema::connection($connection)->create('assignment_tags', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->timestamps();
		});

		Schema::connection($connection)->create('assignment_events', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->timestamps();
		});

		Schema::connection($connection)->create('assignment_status', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('ordem')->nullable();
			$table->json('styles')->nullable();
			$table->status('active');
			$table->timestamps();
		});

		Schema::connection($connection)->create('assignment_job_types', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->enum('type', ['S', 'M'])->default('M');
			$table->status('active');
			$table->timestamps();
		});

		Schema::connection($connection)->create('assignment_job_types_logs', function (Blueprint $table) {
			$table->id();
			$table->fk('assignment_id', 'assignments')->onDelete('cascade');
			$table->fk('job_type_id', 'job_types')->onDelete('cascade');
			$table->timestamps();
		});
		Schema::connection($connection)->create('assignment_status_logs', function (Blueprint $table) {
			$table->id();
			$table->fk('assignment_id', 'assignments')->onDelete('cascade');
			$table->fk('status_id', 'assignment_status')->onDelete('cascade');
			$table->by(['created_by']);
			$table->timestamps();
		});
/*		Schema::connection($connection)->create('assignment_authorizations', function (Blueprint $index) {
			$index->id();
			$index->fk('assignment_id', 'assignments')->onDelete('cascade');
			$index->fk('authorization_id', 'authorizations')->onDelete('cascade');
			$index->timestamps();
		});*/
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		$connection = get_connection();

		Schema::connection($connection)->dropIfExists('assignment_status_logs');
		Schema::connection($connection)->dropIfExists('assignment_job_types_logs');
		Schema::connection($connection)->dropIfExists('assignment_job_types');
		Schema::connection($connection)->dropIfExists('assignment_status');
		Schema::connection($connection)->dropIfExists('assignment_events');
		Schema::connection($connection)->dropIfExists('assignment_tags');
		Schema::connection($connection)->dropIfExists('assignment_schedules');
		Schema::connection($connection)->dropIfExists('assignments');
	}

}
