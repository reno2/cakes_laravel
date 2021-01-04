<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
                $table->bigIncrements('id');
		        $table->string('title');
		        $table->string('slug')->unique();
		        $table->text('description_short')->nullable();
		        $table->text('description')->nullable();
		        $table->string('image')->nullable();
		        $table->boolean('image_show')->nullable();
		        $table->string('meta_title')->nullable();
		        $table->string('meta_description')->nullable();
		        $table->boolean('published');
		        $table->integer('created_by')->nullable();
		        $table->integer('modified_by')->nullable();
                $table->integer('sort')->nullable();
                $table->boolean('on_front');
                $table->string('up_post')->nullable();
                $table->double('price')->default(0);
                $table->double('weight')->default(0);
                $table->unsignedMediumInteger('views')->default(0);
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
        Schema::dropIfExists('articles');
    }
}
