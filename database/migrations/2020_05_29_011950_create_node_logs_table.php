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
        Schema::create('changelog_nodes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('node_id');
            $table->unsignedBigInteger('updated_by')->nullable()->default(null);
            $table->timestamps();

            $table->foreign('node_id')->references('id')->on('holocron_nodes')->onDelete('cascade');
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
        Schema::dropIfExists('changelog_nodes');
    }
}
