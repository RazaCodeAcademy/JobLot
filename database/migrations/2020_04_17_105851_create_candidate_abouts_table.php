<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidateAboutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidate_abouts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('about')->nullable();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->nullable();
            $table->string('experience')->nullable();
            $table->string('salary')->nullable();
            $table->string('gender')->nullable();
            $table->string('age')->nullable();
            $table->string('qualification')->nullable();

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
        Schema::dropIfExists('candidate_abouts');
    }
}
