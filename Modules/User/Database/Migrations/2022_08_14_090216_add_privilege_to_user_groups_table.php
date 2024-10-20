<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrivilegeToUserGroupsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::table('user_groups', function (Blueprint $table) {
            $table->enum('privilege', ['admin', 'editor', 'viewer'])->default('viewer')->after('active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::table('user_groups', function (Blueprint $table) {
            $table->dropColumn('privilege');
        });
    }

}
