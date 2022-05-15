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
		        $table->boolean('published')->nullable();
		        $table->integer('created_by')->nullable();
		        $table->integer('modified_by')->nullable();
                $table->integer('sort')->nullable();
                $table->boolean('on_front')->default(0)->nullable();
                $table->boolean('delivery_self')->default(0)->nullable();
                $table->boolean('deal')->default(0)->nullable();
                $table->string('up_post')->nullable();
                $table->string('product_type')->nullable();
                $table->text('service')->nullable();
                $table->text('deal_address')->nullable();
                $table->double('price')->default(0)->nullable();
                $table->string('weight')->default(0)->nullable();
                $table->boolean('moderate')->default(0)->nullable();
                $table->text('moderate_text')->nullable();
                $table->unsignedBigInteger('user_id')->nullable(false);
                $table->softDeletes();
                $table->timestamps();

        });
        Schema::table('articles', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')
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
        Schema::dropIfExists('articles');
    }
}
