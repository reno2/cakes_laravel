<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('from_user_id')->nullable();
            $table->string('from_user_email')->nullable();
            $table->string('room')->nullable();
            $table->integer('parent_id')->nullable();
            $table->timestamp('recipient_read_at')->nullable();
            $table->timestamp('sender_read_at')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('article_id')->nullable();


            $table->string('comment');
            $table->boolean('approved')->default(1);
            $table->timestamps();
        });
        Schema::table('comments', function(Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
