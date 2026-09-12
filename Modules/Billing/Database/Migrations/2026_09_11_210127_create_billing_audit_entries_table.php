<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingAuditEntriesTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('billing_audit_entries')) {
            return;
        }

        // Append-only por design (acordado com a Joline): nunca é dado update, só insert.
        Schema::create('billing_audit_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billing_plan_id')->index();
            $table->unsignedBigInteger('billing_line_item_id')->nullable()->index();

            // plan_generated | item_added | confidence_assigned | exception_raised | exception_resolved | compared_to_real_estimate | status_changed
            $table->string('action', 60)->index();
            $table->string('field', 60)->nullable();
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();
            $table->text('reasoning')->nullable();

            // quem/o quê gerou a entrada: 'system:validation_engine', e-mail/id de usuário, etc.
            $table->string('actor', 120)->nullable();

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_audit_entries');
    }
}
