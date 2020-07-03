<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('desk')->nullable();
            $table->string('family_name')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable()->unique();
            $table->datetime('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('address_current')->nullable();
            $table->string('gender')->nullable();
            $table->string('passport')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('jpn_phone')->nullable();
            $table->date('dob')->nullable();
            $table->string('age')->nullable();
            $table->string('country')->nullable();
            $table->string('company')->nullable();            
            $table->string('emp_phone_no')->nullable();            
            $table->string('emp_address')->nullable();            
            $table->string('avatar')->nullable();
            $table->string('disease')->nullable();
            $table->string('surgery')->nullable();
            $table->string('medicine')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('approved')->default(0)->nullable();
            $table->boolean('verified')->default(1)->nullable();
            $table->datetime('verified_at')->nullable();
            $table->string('verification_token')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
