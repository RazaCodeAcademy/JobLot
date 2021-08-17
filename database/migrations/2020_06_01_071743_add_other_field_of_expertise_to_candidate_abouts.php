<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOtherFieldOfExpertiseToCandidateAbouts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('candidate_abouts', function (Blueprint $table) {
            $table->string('other_field_of_expertise')->after('field_of_expertise')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('candidate_abouts', function (Blueprint $table) {
            $table->dropColumn('other_field_of_expertise');
        });
    }
}
