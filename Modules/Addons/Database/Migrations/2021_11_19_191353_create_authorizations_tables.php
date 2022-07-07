<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorizationsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		$connection = get_connection();

		Schema::connection($connection)->create('authorizations', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('description');
			$table->longText('b64');
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
		Schema::connection($connection)->dropIfExists('authorizations');
	}

}
