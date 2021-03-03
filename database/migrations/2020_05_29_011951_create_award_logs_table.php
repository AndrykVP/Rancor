<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodeLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('changelog_awards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('award_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('action');
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('award_id')->references('id')->on('structure_awards')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('changelog_awards');
    }
}
