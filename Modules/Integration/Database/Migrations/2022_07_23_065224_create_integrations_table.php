<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIntegrationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('integrations', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->morphs('syncable');
            $table->timestamps();
        });

        Schema::create('integration_queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue');
            $table->enum('status', ['pending', 'processing', 'complete', 'error']);
            $table->timestamps();
        });

        Schema::create('integration_failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue');
            $table->json('transaction')->nullable();
            $table->longText('payload')->nullable();
            $table->longText('exception')->nullable();
            $table->timestamp('failed_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
        Schema::dropIfExists('integration_failed_jobs');
        Schema::dropIfExists('integration_queues');
        Schema::dropIfExists('integrations');
    }

}
