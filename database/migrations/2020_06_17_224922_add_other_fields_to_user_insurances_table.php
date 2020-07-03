<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherFieldsToUserInsurancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_insurances', function (Blueprint $table) {
            $table->string('corporate_company')->nullable();
            $table->longText('cash_comments')->nullable();
            $table->longText('other_comments')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_insurances', function (Blueprint $table) {
            //
        });
    }
}
