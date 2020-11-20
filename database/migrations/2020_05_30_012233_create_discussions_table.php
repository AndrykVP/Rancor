<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_discussions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->boolean('is_sticky');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('replies')->default(0);
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('author_id');
            $table->timestamps();

            $table->foreign('board_id')->references('id')->on('forum_boards')->onDelete('cascade');
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_discussions');
    }
}
