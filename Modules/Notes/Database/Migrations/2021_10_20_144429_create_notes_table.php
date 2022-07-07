<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->unsignedBigInteger('notable_id');
            $table->string('notable_type');
            $table->enum('type', array('assignment', 'tech', 'finance', 'billing', 'payment', 'referral', 'no_job'));
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->timestamps();
        });
        Schema::create('directions', function (Blueprint $table) {
            $table->id();
            $table->string('origin');
            $table->string('destination');
            $table->string('text');
            $table->integer('value');
            $table->timestamps();
        });
//        Schema::create('notes', function (Blueprint $table) {
//            $table->increments('id');
////            $table->morphs('notable');
//            $table->integer('notable_id');
//            $table->string("notable_type");
//            $table->text('text');
////            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('directions');
        Schema::dropIfExists('notes');
    }
}
