<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyvalueableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propertyvalueables', function (Blueprint $table) {
            // ид и название, модели с которой устанавливается свяль
            $table->integer('property_value_id');
            // ид связанной модели, тут будет модель article
            $table->integer('propertyvalueable_id');
            // Связагная модель в которой ищется значение поля property_names
            $table->string('propertyvalueable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propertyvalueables');
    }
}
