<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up ()
    {
        Schema::create('assignments_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->string('ordem');
            $table->string('color')->nullable();
            $table->enum('active', ['Y', 'N'])->default('N');
            $table->timestamps();
        });
        Schema::create('assignments_status_collection', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('class');
            $table->string('ordem');
            $table->string('color')->nullable();
            $table->enum('active', ['Y', 'N'])->default('N');
            $table->timestamps();
        });
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('assignments_status')->onDelete('cascade');
            $table->foreignId('status_collection_id')->constrained('assignments_status_collection')->onDelete('cascade');
            $table->unsignedBigInteger('event_id')->nullable();
            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->string('carrier_info')->nullable();
            $table->timestamp('date_of_loss')->nullable();
            $table->timestamp('date_assignment')->nullable();
            $table->timestamp('follow_up')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('claim_number')->nullable();
            $table->text('adjuster_info')->nullable();
            $table->text('inside_info')->nullable();

            $table->timestamps();
        });

        Schema::create('assignments_phones', function (Blueprint $table) {

            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->string('contact')->nullable();
            $table->string('phone');
            $table->enum('preferred', ['Y', 'N'])->default('N');
            $table->timestamps();
        });
        Schema::create('assignments_job_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type', ['S', 'M'])->default('M');
            $table->enum('active', ['Y', 'N'])->default('N');
            $table->string('view');
        });

        Schema::create('assignments_job_types_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('assignment_job_type_id')->constrained('assignments_job_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('assignments_status_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('assignment_status_id')->constrained('assignments_status')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('assignments_authorization_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('authorization_id')->constrained('referral_authorizations')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('assignments_tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
        Schema::create('assignments_tags_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('tag_id')->constrained('assignments_tags')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('assignments_events', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });


        Schema::create('assignments_scheduling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('tech_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });

        Schema::create('gallery_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('active', ['Y', 'N'])->default('N');
            $table->timestamps();
        });

        Schema::create('gallery', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('gallery_categories')->onUpdate('cascade');;
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade');
            $table->bigInteger('img_id');
            $table->longText('b64');
            $table->enum('type', ['start_job', 'pics_inside', 'pics_before', 'pics_after']);
            $table->timestamps();
        });

        Schema::create('job_report', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('assignment_job_type_id')->constrained('assignments_job_types');
            $table->dateTime('service_date');
            $table->string('pitch')->nullable();
            $table->integer('sandbags')->nullable();
            $table->enum('anchoring_support', ['Y', 'N'])->default('Y');
            $table->enum('tarp_alterations', ['Y', 'N'])->default('N');
            $table->enum('tarp_situation', ['Y', 'N'])->default('N');
            $table->enum('height_accomodation', ['Y', 'N'])->default('N');
            $table->enum('debris', ['haul', 'leave'])->default('leave');
            $table->integer('loads')->nullable();
            $table->enum('wood_chipper', ['Y', 'N'])->default('N');
            $table->enum('crane', ['Y', 'N'])->default('N');
            $table->enum('bobcat_use', ['Y', 'N'])->default('N');
            $table->enum('bobcat_type', ['bobcat', 'mini_skid_loader'])->nullable();
            $table->integer('bobcat_hour')->nullable();
            $table->longText('job_info')->nullable();
            $table->longText('plywoods')->nullable();
            $table->longText('s2x4x8')->nullable();
            $table->longText('s2x4x12')->nullable();
            $table->longText('s2x4x16')->nullable();
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade');

            $table->timestamps();
        });
        Schema::create('job_report_options', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->timestamps();
        });
        Schema::create('job_report_options_pivot', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_option_id')->constrained('job_report_options')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('assignments_job_types')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('stock_tarps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });
        Schema::create('job_report_tarp_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('width');
            $table->integer('height');
            $table->integer('qty');
            $table->foreignId('stock_id')->constrained('stock_tarps')->onUpdate('cascade');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('assignments_job_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('job_report_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_option_id')->constrained('job_report_options')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('assignments_job_types')->onDelete('cascade');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('job_report_workers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('worker_id')->constrained('users')->onUpdate('cascade');
            $table->foreignId('job_type_id')->constrained('assignments_job_types')->onUpdate('cascade');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('job_report_tree_sizes', function (Blueprint $table) {
            $table->id();
            $table->integer('length');
            $table->integer('diameter');
            $table->integer('canopy');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('assignments_job_types')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('job_report_service_time', function (Blueprint $table) {
            $table->id();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('workers');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('job_type_id')->constrained('assignments_job_types')->onDelete('cascade');

            $table->timestamps();
        });
        Schema::create('signdata', function (Blueprint $table) {
            $table->id();

            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->longText('b64');
            $table->enum('type', ['app', 'system']);
            $table->dateTime('date_sign')->nullable();
            $table->enum('preferred', ['Y', 'N'])->default('N');

            $table->timestamps();
        });

        Schema::create('finance_billing', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade');
            $table->decimal('billed_amount')->default('0');
            $table->decimal('fee_amount')->default('0');
            $table->decimal('discount_amount')->default('0');
            $table->decimal('settlement_amount')->default('0');
            $table->dateTime('billed_date');
            $table->enum('type', ['active', 'disable']);
            $table->enum('status', ['billed', 'partial_payment', 'paid'])->default('billed');
            $table->enum('lien', ['Y', 'N'])->default('N');

            $table->timestamps();
        });

        Schema::create('finance_payment', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');

            $table->enum('payment_type', ['partial_payment', 'total_payment', 'fee_payment', 'refund_payment']);
            $table->enum('type', ['active', 'disable']);
            $table->foreignId('assignment_id')->constrained('assignments')->onDelete('cascade');
            $table->foreignId('created_by')->constrained('users')->onUpdate('cascade');
            $table->foreignId('updated_by')->constrained('users')->onUpdate('cascade');
            $table->decimal('amount')->default('0');
            $table->dateTime('payment_date');

            $table->timestamps();
        });
//        Schema::create('techs', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
//            $table->enum('active', ['Y', 'N'])->default('N');
//            $table->timestamps();
//        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down ()
    {
//        Schema::dropIfExists('techs');
        Schema::dropIfExists('finance_payment');
        Schema::dropIfExists('finance_billing');
        Schema::dropIfExists('signdata');
        Schema::dropIfExists('job_report_service_time');
        Schema::dropIfExists('job_report_tree_sizes');
        Schema::dropIfExists('job_report_workers');
        Schema::dropIfExists('job_report_reports');
        Schema::dropIfExists('job_report_tarp_sizes');
        Schema::dropIfExists('stock_tarps');
        Schema::dropIfExists('job_report_options_pivot');
        Schema::dropIfExists('job_report_options');
        Schema::dropIfExists('job_report');
        Schema::dropIfExists('gallery');
        Schema::dropIfExists('gallery_categories');
        Schema::dropIfExists('assignments_scheduling');
//        Schema::dropIfExists('assignments_event_pivot');
        Schema::dropIfExists('assignments_events');
        Schema::dropIfExists('assignments_tags_pivot');
        Schema::dropIfExists('assignments_tags');
        Schema::dropIfExists('assignments_authorization_pivot');
        Schema::dropIfExists('assignments_status_pivot');
        Schema::dropIfExists('assignments_job_types_pivot');
        Schema::dropIfExists('assignments_job_types');
        Schema::dropIfExists('assignments_phones');
        Schema::dropIfExists('assignments');
        Schema::dropIfExists('assignments_status_collection');
        Schema::dropIfExists('assignments_status');
    }

}
