<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollectionsTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		$connection = get_connection();

		Schema::connection($connection)->create('collection_authorizations', function (Blueprint $table) {
			$table->id();
			$table->fk('authorization_id', 'authorizations')->onDelete('cascade');
			$table->nullableMorphs('collect');
			$table->status('active');
			$table->timestamps();
		});

		Schema::connection($connection)->create('collection_phones', function (Blueprint $table) {
			$table->id();
			$table->morphs('collect');
			$table->phone();
			$table->timestamps();
		});

		Schema::connection($connection)->create('collection_notes', function (Blueprint $table) {
			$table->id();
			$table->morphs('collect');
			$table->text('text');
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
		Schema::connection($connection)->dropIfExists('collection_notes');
		Schema::connection($connection)->dropIfExists('collection_phones');
		Schema::connection($connection)->dropIfExists('collection_authorizations');
	}

}
