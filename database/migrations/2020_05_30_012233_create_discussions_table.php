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
            $table->string('name');
            $table->boolean('is_sticky')->default(0);
            $table->boolean('is_locked')->default(0);
            $table->unsignedBigInteger('views')->default(0);
            $table->foreignId('board_id')->constrained('forum_boards')->onDelete('cascade');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('forum_discussions');
    }
}
