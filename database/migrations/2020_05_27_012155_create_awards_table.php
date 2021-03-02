<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structure_awards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable()->default(null);
            $table->string('code')->unique();
            $table->unsignedInteger('levels')->default(1);
            $table->unsignedInteger('priority')->default(1);
            $table->unsignedBigInteger('type_id');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('structure_award_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('structure_awards');
    }
}
