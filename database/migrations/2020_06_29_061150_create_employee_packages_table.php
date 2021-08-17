<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_packages', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('package_id');

            $table->integer('payment_id');
            $table->integer('invoice_id');
            $table->integer('order_id');
            $table->integer('authorization_id');
            
            $table->string('package_name');
            $table->string('currency');
            $table->string('amount_paid');
            $table->string('payment_gateway');


            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');

            $table->integer('jobs_limit');
            $table->integer('cv_limit');
            $table->integer('jobs_count')->default(0);
            $table->boolean('status')->default(1); // 1 = active, 0 = inactive

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');

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
        Schema::dropIfExists('employee_packages');
    }
}
