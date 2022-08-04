<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {

        Schema::create('employee_timesheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('week')->nullable();
            $table->integer('year')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('due_on')->nullable();
            $table->string('status')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_timesheet_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_timesheet_id')->constrained('employee_timesheets')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->dateTime('date')->nullable();
            $table->string('day_week')->nullable();
            $table->string('off')->nullable();
            $table->string('out')->nullable();
            $table->string('oncall')->nullable();
            $table->string('morning')->nullable();
            $table->string('afternoon')->nullable();
            $table->string('hurricane')->nullable();
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
        Schema::dropIfExists('employee_timesheet_days');
        Schema::dropIfExists('employee_timesheets');
        Schema::dropIfExists('employee_group_pivot');
        Schema::dropIfExists('employee_groups');
    }

}
