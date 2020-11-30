<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValuefiltersables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('valuefiltersables', function (Blueprint $table) {
            $table->integer('value_id'); // ид и название, модели с которой устанавливается свяль
            $table->integer('valuefiltersable_id'); // ид связанной модели, тут модель article
            $table->string('valuefiltersable_type'); // Связагная модель в которой ищется значение поля groupsable_id
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('valuefiltersables');
    }
}
