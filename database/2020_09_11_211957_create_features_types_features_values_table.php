<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeaturesTypesFeaturesValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feature_types_feature_values', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feature_types_id')->unsigned();
            $table->foreign('feature_types_id')->references('id')->on('feature_types');
            $table->integer('feature_values_id')->unsigned();
            $table->foreign('feature_values_id')->references('id')->on('feature_values');


            //$table->integer('feature_types_id');
            //$table->integer('feature_values_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('features_types_features_values');
    }
}
