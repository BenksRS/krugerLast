<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQueeLabelingTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('quee_labeling')) {
            return;
        }

        Schema::create('quee_labeling', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id')->index();
            $table->integer('order')->default(50);
            // pending -> processing -> awaiting_ai -> complete / error
            $table->string('status', 30)->default('pending')->index();
            $table->string('batch_id')->nullable();
            $table->longText('payload')->nullable();
            $table->longText('history')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quee_labeling');
    }
}
