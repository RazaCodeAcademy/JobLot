<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageFeatureListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_feature_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('package_details_id');
            $table->string('feature_name');


            $table->foreign('package_details_id')->references('id')->on('package_details')->onDelete('cascade');
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
        Schema::dropIfExists('package_feature_lists');
    }
}
