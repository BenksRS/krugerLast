<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApiConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('token_id');
            $table->unsignedBigInteger('device_id');
            $table->timestamps();
        });

        Schema::table('api_connections', function (Blueprint $table) {
            $table->foreign('token_id')->references('id')->on('api_tokens');
            $table->foreign('device_id')->references('id')->on('api_devices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('api_connections');
    }
}
