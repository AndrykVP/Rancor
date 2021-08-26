<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionNodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holocron_collection_node', function (Blueprint $table) {
            $table->foreignId('collection_id')->constrained('holocron_collections')->onDelete('cascade');
            $table->foreignId('node_id')->constrained('holocron_nodes')->onDelete('cascade');
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
        Schema::dropIfExists('holocron_collection_node');
    }
}
