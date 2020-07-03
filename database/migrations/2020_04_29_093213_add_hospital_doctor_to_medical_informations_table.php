<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHospitalDoctorToMedicalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('medical_informations', function (Blueprint $table) {
            $table->unsignedInteger('doctor_id')->nullable();
            $table->foreign('doctor_id', 'doctor_fk_538500')->references('id')->on('doctors');
            $table->unsignedInteger('department_id')->nullable();
            $table->foreign('department_id', 'department_fk_538501')->references('id')->on('departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('medical_informations', function (Blueprint $table) {
            //
        });
    }
}
