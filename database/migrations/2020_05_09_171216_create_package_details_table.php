<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_id');
            $table->string('package_description');
            $table->string('currency');
            $table->mediumInteger('monthly_rate');
            $table->mediumInteger('yearly_rate');
            $table->integer('job_limit_monthly');
            $table->integer('job_limit_yearly');
            $table->integer('cv_limit_monthly');
            $table->integer('cv_limit_yearly');
            $table->string('max_users')->nullable();

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
        Schema::dropIfExists('package_details');
    }
}
