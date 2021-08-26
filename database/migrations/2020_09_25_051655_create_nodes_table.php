<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holocron_nodes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->longText('body');
            $table->foreignId('author_id')->nullable()->default(null)->constrained('users')->onDelete('set null');
            $table->foreignId('editor_id')->nullable()->default(null)->constrained('users')->onDelete('set null');
            $table->boolean('is_public');
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
        Schema::dropIfExists('holocron_nodes');
    }
}
