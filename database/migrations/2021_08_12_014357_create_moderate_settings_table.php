<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModerateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderate_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moderate_id')
                  ->constrained('moderates')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->foreignId('settings_id')
                  ->constrained('settings')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::table('moderate_settings', function (Blueprint $table){
         //  $table->dropForeign(['moderate_settings_moderate_id_foreign']);
        //   $table->dropForeign(['moderate_settings_settings_id_foreign']);
      //  });
        Schema::dropIfExists('moderate_settings');
    }
}
