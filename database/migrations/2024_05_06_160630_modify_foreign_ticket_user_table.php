<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ticket_user', function (Blueprint $table) {
            $table->dropForeign('ticket_user_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('ticket_user', function (Blueprint $table) {
            $table->foreignUuid('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ticket_user', function (Blueprint $table) {
            $table->dropForeign('ticket_user_user_id_foreign');
            $table->dropColumn('user_id');
        });

        Schema::table('ticket_user', function (Blueprint $table) {
            $table->foreignUuid('user_id')->references('id')->on('users');
        });
    }
};
