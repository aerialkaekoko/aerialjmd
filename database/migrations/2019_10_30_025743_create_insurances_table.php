<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('insurances', function (Blueprint $table) {
            $table->increments('id');

            $table->string('company_name');            
            $table->string('phone')->nullable();
            $table->string('style')->nullable();
            $table->string('address')->nullable();
            $table->string('template')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}