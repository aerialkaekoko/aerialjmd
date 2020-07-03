<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorHospitalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_hospital', function (Blueprint $table) {

            $table->unsignedInteger('hospital_id');

            $table->foreign('hospital_id', 'hospital_id_fk_515497')->references('id')->on('hospitals')->onDelete('cascade');

            $table->unsignedInteger('doctor_id');

            $table->foreign('doctor_id', 'doctor_id_fk_515497')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctor_hospital');
    }
}
