<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReportingIndexes extends Migration
{
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->index(['status_id', 'follow_up'], 'assignments_status_id_follow_up_index');
        });

        Schema::table('finance_billing', function (Blueprint $table) {
            $table->index(['assignment_id', 'type', 'billed_date'], 'finance_billing_assignment_type_billed_date_index');
        });
    }

    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropIndex('assignments_status_id_follow_up_index');
        });

        Schema::table('finance_billing', function (Blueprint $table) {
            $table->dropIndex('finance_billing_assignment_type_billed_date_index');
        });
    }
}
