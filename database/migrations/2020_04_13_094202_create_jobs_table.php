<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title')->nullable();
            $table->text('slug')->nullable();
            $table->string('category')->nullable();
            $table->string('job_location')->nullable();
            $table->string('type')->nullable();
            $table->string('experience')->nullable();
            $table->string('salary')->nullable();
            $table->string('qualification')->nullable();
            $table->string('gender')->nullable();
            $table->string('vacancy')->nullable();
            $table->date('date')->nullable();
            $table->string('description')->nullable();
            $table->longText('responsibilities')->nullable();
            $table->string('education')->nullable();
            $table->string('benefits')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->mediumInteger('zip_code')->nullable();
            $table->string('your_location')->nullable();
            $table->string('pin_location')->nullable();
            $table->string('companyName')->nullable();
            $table->string('webAddress')->nullable();
            $table->string('companyProfile')->nullable();
            $table->string('selectPackage')->nullable();
            $table->integer('agreement')->nullable();
            $table->integer('count')->default(0);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('jobs');
    }
}
