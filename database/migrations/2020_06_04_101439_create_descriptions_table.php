<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('descriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('invoice_id')->unsigned()->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->integer('invoice_description_id')->unsigned()->nullable();
            $table->foreign('invoice_description_id')->references('id')->on('invoice_descriptions');
            $table->string('remark')->nullable();
            $table->integer('qty')->nullable();
            $table->float('unit_price', 8, 2)->default(0);
            $table->integer('currency1')->default(0);
            $table->float('amount', 8, 2)->default(0);
            $table->tinyInteger('vatable_status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('descriptions');
    }
}
