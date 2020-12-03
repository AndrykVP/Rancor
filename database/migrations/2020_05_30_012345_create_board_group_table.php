<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forum_board_group', function (Blueprint $table) {
            $table->unsignedBigInteger('board_id');
            $table->unsignedBigInteger('group_id');
            $table->timestamps();

            $table->foreign('board_id')->references('id')->on('forum_boards')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('forum_groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('forum_board_group');
    }
}
