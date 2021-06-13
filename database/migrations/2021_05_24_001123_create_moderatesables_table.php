<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModeratesablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderatesables', function (Blueprint $table) {
            // ид и название, модели с которой устанавливается связь в нашем случи модель PropertyName
            $table->integer('moderate_id');
            // ид связанной модели, тут будет модель article
            $table->integer('moderatesable_id');
            // Связагная модель в которой ищется значение поля property_names
            $table->string('moderatesable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderatesables');
    }
}
