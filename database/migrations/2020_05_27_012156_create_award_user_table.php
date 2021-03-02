<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_award_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('award_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('level');
            $table->timestamps();

            $table->foreign('award_id')->references('id')->on('structure_awards')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_award_user');
    }
}
