<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingPlansTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('billing_plans')) {
            return;
        }

        Schema::create('billing_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('assignment_id')->index();
            $table->unsignedBigInteger('job_report_id')->nullable()->index();

            // draft: gerado, ainda não revisado. shadow: rodando em paralelo ao billing manual (Fase 1), só pra comparação.
            $table->string('status', 30)->default('draft')->index();

            // HIGH | MEDIUM | LOW | CONFLICT — agregado a partir dos line items (o pior confidence entre eles)
            $table->string('overall_confidence', 20)->nullable()->index();

            $table->unsignedBigInteger('generated_by')->nullable();
            $table->text('notes')->nullable();

            // Comparação com o estimate real feito manualmente (Xactimate), enquanto não há execução automática
            $table->decimal('real_estimate_total', 12, 2)->nullable();
            $table->decimal('plan_total', 12, 2)->nullable();
            $table->decimal('total_variance', 12, 2)->nullable();
            $table->timestamp('compared_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_plans');
    }
}
