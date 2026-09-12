<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingExceptionsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('billing_exceptions')) {
            return;
        }

        Schema::create('billing_exceptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billing_plan_id')->index();
            $table->unsignedBigInteger('billing_line_item_id')->nullable()->index();

            // low | conflict | missing_info
            $table->string('type', 30)->index();
            $table->text('reason');

            // open | resolved | dismissed — autoridade final combinada com a Joline: Nadal
            $table->string('status', 20)->default('open')->index();
            $table->unsignedBigInteger('resolved_by')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->text('resolution_notes')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_exceptions');
    }
}
