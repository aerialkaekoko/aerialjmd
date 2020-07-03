<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('local_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->string('company_name')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    }
}