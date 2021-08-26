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
            $table->string('name');
            $table->longText('body');
            $table->text('description');
            $table->boolean('is_published')->default(0);
            $table->foreignId('author_id')->nullable()->default(null)->constrained('users')->onDelete('set null');
            $table->foreignId('editor_id')->nullable()->default(null)->constrained('users')->onDelete('set null');
            $table->timestamp('published_at')->nullable()->default(null);
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
        Schema::dropIfExists('news_articles');
    }
}
