<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('avatar')->nullable()->default(null)->after('name');
            $table->text('signature')->nullable()->default(null)->after('avatar');
            $table->string('nickname')->nullable()->default(null)->after('email');
            $table->text('quote')->nullable()->default(null)->after('nickname');
            $table->foreignId('rank_id')->nullable()->default(null)->after('quote')->constrained('structure_ranks')->onDelete('set null');
            $table->boolean('show_email')->default(1)->after('rank_id');
            $table->boolean('is_admin')->default(0)->after('show_email');
            $table->boolean('is_banned')->default(0)->after('is_admin');
            $table->smallText('ban_reason')->nullable()->default(null)->after('is_banned');
            $table->timestamp('last_login')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn([
                'avatar',
                'signature',
                'nickname',
                'quote',
                'rank_id',
                'show_email',
                'is_admin',
                'is_banned',
                'ban_reason',
                'last_login'
            ]);
        });
    }
}
