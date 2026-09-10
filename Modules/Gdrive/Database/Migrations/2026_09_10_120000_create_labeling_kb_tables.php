<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelingKbTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('labeling_rules')) {
            Schema::create('labeling_rules', function (Blueprint $table) {
                $table->id();
                $table->string('section', 60)->default('General');
                $table->text('body');
                $table->boolean('active')->default(true);
                $table->integer('sort')->default(100);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('labeling_vocabulary')) {
            Schema::create('labeling_vocabulary', function (Blueprint $table) {
                $table->id();
                $table->string('category', 80)->default('Other');
                $table->string('term', 160);
                $table->boolean('active')->default(true);
                $table->integer('sort')->default(100);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('labeling_banned')) {
            Schema::create('labeling_banned', function (Blueprint $table) {
                $table->id();
                $table->string('term', 120);
                $table->boolean('active')->default(true);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('labeling_examples')) {
            Schema::create('labeling_examples', function (Blueprint $table) {
                $table->id();
                $table->string('image_path');           // relativo a storage/app/
                $table->string('description', 160);
                $table->string('category', 80)->default('Other');
                $table->text('note')->nullable();
                $table->string('job_number', 30)->nullable();
                $table->boolean('active')->default(true);
                $table->unsignedBigInteger('created_by')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('labeling_rules');
        Schema::dropIfExists('labeling_vocabulary');
        Schema::dropIfExists('labeling_banned');
        Schema::dropIfExists('labeling_examples');
    }
}
