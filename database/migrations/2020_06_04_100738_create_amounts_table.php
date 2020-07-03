<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('invoice_code')->unique();
            $table->float('subtotal_amount', 8, 2)->default(0);
            $table->float('vatable_amount', 8, 2)->default(0);
            $table->integer('vatable_percent')->nullable();
            $table->float('calculate_vatable_amount',8,2)->default(0);
            $table->float('non_vatable',8,2)->default(0);
            $table->float('total_amount',8,2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('amounts');
    }
}
