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
        Schema::table('tickets', function (Blueprint $table) {
            if(Schema::hasColumn('tickets', 'tickets_ticket_user_id_foreign')) {
                $table->dropForeign('tickets_ticket_user_id_foreign');
            }
        });

        Schema::table('ticket_user', function (Blueprint $table) {
            $table->string('id')->change();
        });

        Schema::table('tickets', function(Blueprint $table) {
            if(!Schema::hasColumn('tickets', 'ticket_user_id')) {
                $table->foreignUuid('ticket_user_id')->references('id')->on('ticket_user');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tickets', function (Blueprint $table) {
            if(Schema::hasColumn('tickets', 'tickets_ticket_user_id_foreign')) {
                $table->dropForeign('tickets_ticket_user_id_foreign');
            }
        });

        Schema::table('ticket_user', function (Blueprint $table) {
            $table->uuid('id')->change();
        });

        Schema::table('tickets', function(Blueprint $table) {
            if(!Schema::hasColumn('tickets', 'ticket_user_id')) {
                $table->foreignUuid('ticket_user_id')->references('id')->on('ticket_user');
            }
        });
    }
};
