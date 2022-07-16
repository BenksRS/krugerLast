<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGdrivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gdrive', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->string('job_path')->nullable();
            $table->string('kruger_pictures_path')->nullable();
            $table->string('pics_front_kruger_path')->nullable();
            $table->string('pics_inside_kruger_path')->nullable();
            $table->string('pics_before_kruger_path')->nullable();
            $table->string('pics_after_kruger_path')->nullable();
            $table->string('pictures_path')->nullable();
            $table->string('pics_before_path')->nullable();
            $table->string('pics_after_path')->nullable();
            $table->string('forms_path')->nullable();
            $table->string('job_link')->nullable();
            $table->string('kruger_pictures_link')->nullable();
            $table->string('pics_link')->nullable();
            $table->string('forms_link')->nullable();

            $table->timestamps();
        });
        Schema::create('quee_dir', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->bigInteger('order')->nullable();
            $table->enum('status', ['pending', 'processing', 'complete', 'error']);
            $table->text('history')->nullable();

            $table->timestamps();
        });
        Schema::create('quee_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->bigInteger('order')->nullable();
            $table->enum('status', ['pending', 'processing', 'complete', 'error']);
            $table->text('history')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gdrive');
    }
}
