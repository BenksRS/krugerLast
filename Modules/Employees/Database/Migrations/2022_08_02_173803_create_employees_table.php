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

        Schema::create('employee_receipts', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->longText('b64');
            $table->decimal('amount')->default('0');
            $table->enum('status', ['pending','approved', 'paid'])->default('pending');
            $table->enum('category', ['GAS', 'AUTOMAINTENANCE', 'MATERIAL', 'UTILITIES'])->default('GAS');
            $table->unsignedBigInteger('paycheck_id')->nullable();
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onUpdate('cascade');
            $table->foreignId('approved_by')->nullable()->constrained('users')->onUpdate('cascade');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

        });

        Schema::create('employee_rules', function (Blueprint $table) {

            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->bigInteger('referral_id')->nullable();
            $table->string('tech_ids')->nullable();
            $table->decimal('porcentagem')->nullable();
            $table->integer('dividir')->default(1);
            $table->decimal('valor')->default(0);
            $table->enum('type', ['J','P', 'R','S','T' ]);
            $table->enum('status', ['active', 'disable'])->default('active');
            $table->decimal('sq_min')->nullable();
            $table->decimal('sq_max')->nullable();
            $table->bigInteger('job_type')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_commissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->bigInteger('job_type')->nullable();
            $table->decimal('amount')->default(0);
            $table->enum('status', ['available', 'paid', 'pending'])->default('pending');
            $table->foreignId('rule_id')->constrained('employee_rules')->onDelete('cascade');
            $table->string('due_month')->nullable();
            $table->string('due_year')->nullable();
            $table->unsignedBigInteger('payroll_id')->nullable();
            $table->timestamps();
        });

        Schema::create('employee_rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('type')->nullable();
            $table->decimal('regular_day')->default(0);
            $table->decimal('weekend_day')->default(0);
            $table->decimal('sleep_out')->default(0);
            $table->decimal('hurricane')->default(0);
            $table->decimal('oncall')->default(0);
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
        Schema::dropIfExists('employee_receipts');
        Schema::dropIfExists('employee_timesheet_days');
        Schema::dropIfExists('employee_timesheets');

    }

}
