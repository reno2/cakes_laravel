<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settingsable', function (Blueprint $table) {
            // ид и название, модели с которой устанавливается связь в нашем случи модель PropertyName
            $table->integer('settings_id');
            // ид связанной модели, тут будет модель article
            $table->integer('settingsable_id');
            // Связагная модель в которой ищется значение поля property_names
            $table->string('settingsable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settingsable');
    }
}
