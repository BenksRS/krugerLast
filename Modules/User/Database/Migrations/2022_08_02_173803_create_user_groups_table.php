<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('active', ['Y', 'N'])->default('N');
            $table->timestamps();
        });

        Schema::create('user_group_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('user_group_id')->constrained('user_groups')->onDelete('cascade');
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
        Schema::dropIfExists('user_group_pivot');
        Schema::dropIfExists('user_groups');
    }

}
