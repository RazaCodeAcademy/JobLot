<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('street_address');
            $table->string('city_name');
            $table->string('state_id');
            $table->string('zip_code');
            $table->string('fcm_token')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone_number')->unique();
            $table->string('password')->nullable();
            $table->string('profile_image')->nullable();
            $table->boolean('terms_and_conditions')->default(0)->comment('0: for not accept 1: for accept');
            $table->boolean('status')->default(1)->comment('0: for not inactive 1: for active');
            $table->date('dob')->after('status')->nullable();
            $table->string('comp_name')->nullable();
            $table->string('comp_location')->nullable();
            $table->string('salary_schedual')->nullable();
            $table->timestamp('job_schedual_from')->nullable();
            $table->timestamp('job_schedual_to')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}