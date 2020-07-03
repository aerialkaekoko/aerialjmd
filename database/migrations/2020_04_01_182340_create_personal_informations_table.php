<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('hospital_id')->unsigned()->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals');
            $table->string('hospital_patient_no')->nullable();
            $table->integer('hospital2_id')->unsigned()->nullable();
            $table->foreign('hospital2_id')->references('id')->on('hospitals');
            $table->string('hospital2_patient_no')->nullable();
            $table->integer('hospital3_id')->unsigned()->nullable();
            $table->foreign('hospital3_id')->references('id')->on('hospitals');
            $table->string('hospital3_patient_no')->nullable();
            $table->string('medicals')->nullable();          
            $table->string('comments')->nullable();
            $table->string('medical_hystory')->nullable();
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
        Schema::dropIfExists('personal_informations');
    }
}
