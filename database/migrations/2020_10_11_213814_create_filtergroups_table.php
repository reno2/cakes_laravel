<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFiltergroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupsables', function (Blueprint $table) {
            $table->integer('groups_id'); // ид группы фильтра
            $table->integer('groupsable_id'); // ид связанной модели, тут модель article
            $table->string('groupsable_type'); // Связагная модель в которой ищется значение поля groupsable_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('filtersgroups');
    }
}
