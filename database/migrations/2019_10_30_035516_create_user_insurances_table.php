<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserInsurancesTable extends Migration
{
    public function up()
    {
        Schema::create('user_insurances', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type')->nullable();
            $table->string('policy_number1')->nullable();
            $table->date('policy_period_from1')->nullable();
            $table->date('policy_period_to1')->nullable();
            $table->string('policy_number2')->nullable();
            $table->date('policy_period_from2')->nullable();
            $table->date('policy_period_to2')->nullable();
            $table->string('member_no')->nullable();
            $table->string('credit_type')->nullable();
            $table->integer('other_type')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
