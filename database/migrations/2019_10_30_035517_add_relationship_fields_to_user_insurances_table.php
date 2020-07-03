<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToUserInsurancesTable extends Migration
{
    public function up()
    {
        Schema::table('user_insurances', function (Blueprint $table) {
            $table->unsignedInteger('user_id');
            $table->foreign('user_id', 'user_fk_538286')->references('id')->on('users');

            $table->unsignedInteger('assistance_id1')->nullable();
            $table->foreign('assistance_id1', 'assistance_fk_538287')->references('id')->on('assistances');

            $table->unsignedInteger('insurance_id1')->nullable();
            $table->foreign('insurance_id1', 'insurance_fk_538288')->references('id')->on('insurances');

            $table->unsignedInteger('assistance_id2')->nullable();
            $table->foreign('assistance_id2', 'assistance2_fk_538289')->references('id')->on('assistances');

            $table->unsignedInteger('insurance_id2')->nullable();
            $table->foreign('insurance_id2', 'insurance2_fk_538290')->references('id')->on('insurances');

            $table->unsignedInteger('membership_id')->nullable();
            $table->foreign('membership_id', 'membership_fk_538291')->references('id')->on('memberships');

            $table->unsignedInteger('credit_insurance_company')->nullable();
            $table->foreign('credit_insurance_company', 'credit_insurance_fk_538292')->references('id')->on('insurances');

            $table->unsignedInteger('credit_assistance_company')->nullable();
            $table->foreign('credit_assistance_company', 'credit_assistrance_fk_538293')->references('id')->on('assistances');

            $table->unsignedInteger('local_insurance_id')->nullable();
            $table->foreign('local_insurance_id', 'credit_assistrance_fk_538294')->references('id')->on('local_insurances');
        });
    }
}
