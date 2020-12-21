<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_articles', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content');
            $table->boolean('is_published');
            $table->unsignedBigInteger('views')->default(0);
            $table->unsignedBigInteger('author_id')->nullable()->default(null);
            $table->unsignedBigInteger('editor_id')->nullable()->default(null);
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
        Schema::dropIfExists('news_articles');
    }
}
