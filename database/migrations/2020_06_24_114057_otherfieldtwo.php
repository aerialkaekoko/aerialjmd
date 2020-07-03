<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Otherfieldtwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_insurances', function (Blueprint $table) {
            $table->integer('other_type_two')->nullable();
            $table->integer('local_insurance_id_two')->nullable();
            $table->string('corporate_company_two')->nullable();
            $table->longText('cash_comments_two')->nullable();
            $table->longText('other_comments_two')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
