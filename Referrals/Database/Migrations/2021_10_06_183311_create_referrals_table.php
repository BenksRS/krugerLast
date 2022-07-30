<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReferralsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('active', array('Y', 'N'))->default('Y');
            $table->timestamps();
        });


        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_type_id')->constrained('referral_types')->onDelete('cascade');

            $table->string('company_entity');
            $table->string('company_fictitions');
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('main_contact')->nullable();
            $table->string('email')->nullable();

            $table->enum('status', array('ACTIVE', 'BLOCKED', 'LEED'))->default('active');
            $table->timestamps();
        });

        Schema::create('referral_phones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade');
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->enum('preferred', array('Y', 'N'))->default('N');

            $table->timestamps();
        });

        Schema::create('referral_authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->longText('b64');
            $table->enum('active', array('Y', 'N'))->default('Y');

            $table->timestamps();
        });

        Schema::create('referral_authorization_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade');
            $table->foreignId('carrier_id')->constrained('referrals')->onDelete('cascade');
            $table->foreignId('referral_authorizathion_id')->constrained('referral_authorizations')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('referral_carriers_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_vendor_id')->constrained('referrals')->references('id')->onDelete('cascade');
            $table->foreignId('referral_carrier_id')->constrained('referrals')->references('id')->onDelete('cascade');
            $table->enum('auth', array('Yes', 'No'))->default('Yes');
            $table->enum('default', array('Yes', 'No'))->default('Yes');
            $table->timestamps();

        });
        Schema::create('referral_billing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade');
            $table->integer('days_from_billing')->nullable();
            $table->integer('days_from_scheduling')->nullable();
            $table->integer('days_from_scheduling_lien')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('field_authorizations', function (Blueprint $table) {
            $table->id();
//            $table->foreignId('referral_id')->constrained('referrals')->onDelete('cascade')->nullable();
            $table->foreignId('referral_authorizathion_id')->constrained('referral_authorizations')->onDelete('cascade');
            $table->integer('height');
            $table->integer('length');
            $table->string('field');


            $table->timestamps();
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('field_authorizations');
        Schema::dropIfExists('referral_billing');
        Schema::dropIfExists('referral_carriers_pivots');
        Schema::dropIfExists('referral_authorization_pivots');
        Schema::dropIfExists('referral_authorizations');
        Schema::dropIfExists('referral_phones');
        Schema::dropIfExists('referrals');
        Schema::dropIfExists('referral_types');
//        Schema::dropIfExists('referrals');
    }
}
