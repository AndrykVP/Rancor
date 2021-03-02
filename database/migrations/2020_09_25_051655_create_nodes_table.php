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
            $table->unsignedBigInteger('author_id')->nullable()->default(null);
            $table->unsignedBigInteger('editor_id')->nullable()->default(null);
            $table->boolean('is_published');
            $table->boolean('is_private');
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            
            $table->foreign('author_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('editor_id')->references('id')->on('users')->onDelete('set null');
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
