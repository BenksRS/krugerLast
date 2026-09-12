<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingLineItemsTable extends Migration
{
    public function up()
    {
        if (Schema::hasTable('billing_line_items')) {
            return;
        }

        Schema::create('billing_line_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('billing_plan_id')->index();

            // tree_removal | roof_tarp | equipment | labor | hauling | other
            $table->string('category', 40)->index();
            $table->string('xactimate_code', 40)->nullable();
            $table->text('description')->nullable();

            $table->decimal('quantity', 12, 2)->nullable();
            $table->string('unit', 20)->nullable();
            $table->decimal('unit_price', 12, 2)->nullable();
            $table->decimal('total', 12, 2)->nullable();

            // HIGH | MEDIUM | LOW | CONFLICT — pior confidence entre os campos do item (confidence_fields)
            $table->string('confidence', 20)->index();

            // Confidence por campo, ex: {"quantity":"HIGH","equipment_operating":"MEDIUM"}
            $table->longText('confidence_fields')->nullable();

            // De onde veio a evidência: job_report fields usados, ids/paths de fotos, aprovações
            $table->longText('evidence')->nullable();

            // Justificativa legível, vira nota do line item no Xactimate e insumo do audit trail
            $table->text('reasoning')->nullable();

            // Comparação manual contra o item real do estimate feito pela Joline/Nadal (Fase 1, sem API ainda)
            $table->longText('matched_real_line_item')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('billing_line_items');
    }
}
