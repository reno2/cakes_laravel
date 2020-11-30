<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupefiltersables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupefiltersables', function (Blueprint $table) {
            $table->integer('property_id'); // ид и название, модели с которой устанавливается свяль
            $table->integer('groupefiltersable_id'); // ид связанной модели, тут модель article
            $table->string('groupefiltersable_type'); // Связагная модель в которой ищется значение поля groupsable_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupefiltersables');
    }
}
