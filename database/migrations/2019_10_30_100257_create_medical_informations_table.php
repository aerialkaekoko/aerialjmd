<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->date('date_of_visit')->nullable();
            $table->string('ba_ref_no')->nullable();
            $table->integer('patient_id')->unsigned()->nullable();
            $table->foreign('patient_id')->references('id')->on('users');
            $table->string('patient_no')->nullable();
            $table->integer('hospital_id')->unsigned()->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals');
            $table->integer('opd_ipd')->nullable();
            $table->date('ipd_start_date')->nullable();
            $table->date('ipd_finish_date')->nullable();
            $table->integer('re_exam')->default(0);
            $table->longText('symptons')->nullable();
            $table->integer('disease_id')->unsigned()->nullable();
            $table->foreign('disease_id')->references('id')->on('medicals'); 
            $table->integer('treatment_status')->default(0);
            $table->dateTime('appointment_date')->nullable();
            $table->string('translator_name')->nullable();
            $table->longText('treatment_info_comments')->nullable();
            $table->float('medical_amount',8,2)->default(0);
            $table->float('medical_amount2',8,2)->default(0);
            $table->float('kb',8,2)->default(0);
            $table->integer('currency')->default(0);
            $table->integer('payment_type')->default(0);
            $table->integer('insurance_id')->unsigned()->nullable();
            $table->foreign('insurance_id')->references('id')->on('insurances');
            $table->integer('assistance_id')->unsigned()->nullable();
            $table->foreign('assistance_id')->references('id')->on('assistances');
            $table->integer('membership_id')->nullable();
            $table->integer('status_of_gcl')->default(0);
            $table->string('gcl_case_no')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('period_case')->nullable();
            $table->longText('gcl_info_comments')->nullable();
            $table->integer('weekday_end')->nullable();
            $table->string('side_response')->nullable();
            $table->string('service_in_time')->nullable();
            $table->string('service_out_time')->nullable();
            $table->date('document_date')->nullable();
            $table->longText('gad_use_comments')->nullable();
            $table->float('exchange_thb',8,2)->default(0);
            $table->float('exchange_lak',8,2)->default(0);
            $table->float('exchange_mmk',8,2)->default(0);
            $table->tinyInteger('appointment_status')->default('0');
            $table->string('branch_code')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medical_informations');
    }
}
