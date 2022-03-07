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
            $table->id();
            $table->string('business_cat_id')->comment('employer business category');
            $table->string('employer_id')->comment('employer_id foriegn key from user');
            $table->string('title')->comment('common title or new title for job');
            $table->string('slug')->nullable();
            $table->string('salary');
            $table->string('job_type')->comment('1: for full time 2: for part time');
            $table->string('job_qualification')->comment('number of years of qulification');
            $table->string('state_authorized')->comment('1: for required 2: for prefer');
            $table->text('description')->nullable();
            $table->boolean('status')->default(0)->comment('0: for inactive 1: for active');
            $table->boolean('job_approval')->default(0)->comment('0: for disapproved 1: for approved');
            $table->timestamp('expired')->nullable();
            $table->string('comp_name')->nullable();
            $table->string('comp_location')->nullable();
            $table->string('salary_schedual')->nullable();
            $table->timestamp('job_schedual_from')->nullable();
            $table->timestamp('job_schedual_to')->nullable();
            $table->integer('count')->nullable();
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
