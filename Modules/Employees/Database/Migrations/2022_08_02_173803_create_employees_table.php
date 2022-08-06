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
            $table->integer('week');
            $table->integer('year');
            $table->timestamp('start_date');
            $table->timestamp('end_date');
            $table->timestamp('due_on');
            $table->enum('status', ['new','pending','approved'])->default('new');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_timesheet_days', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('employee_timesheet_id')->constrained('employee_timesheets')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamp('date');
            $table->string('day_week');
            $table->boolean('off')->default(true);
            $table->boolean('out')->default(false);
            $table->boolean('oncall')->default(false);
            $table->boolean('morning')->default(false);
            $table->boolean('afternoon')->default(false);
            $table->boolean('hurricane')->default(false);
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
