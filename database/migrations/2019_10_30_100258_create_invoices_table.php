<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('invoice_code');
            $table->date('invoice_date');
            $table->string('reference_no');
            $table->integer('qty')->unsigned();
            $table->integer('currency_interpreter')->unsigned();
            $table->float('interpreter_fee',8,2)->default(0);
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('medical_information_id');
            $table->foreign('medical_information_id')->references('id')->on('medical_informations');
            $table->integer('to_assistance_id')->unsigned();
            $table->foreign('to_assistance_id')->references('id')->on('assistances');
            $table->date('send_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->tinyInteger('form_status')->default('0');
            $table->tinyInteger('trf_paid')->default('0');
            $table->string('branch_code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
