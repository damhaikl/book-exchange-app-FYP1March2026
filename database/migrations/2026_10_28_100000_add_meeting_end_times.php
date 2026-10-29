<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->time('meeting_end_time')->nullable();
        });

        Schema::table('book_requests', function (Blueprint $table) {
            $table->time('proposed_end_time')->nullable();
        });

        Schema::table('book_schedules', function (Blueprint $table) {
            $table->time('meeting_end_time')->nullable();
            $table->time('proposed_end_time')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn('meeting_end_time');
        });

        Schema::table('book_requests', function (Blueprint $table) {
            $table->dropColumn('proposed_end_time');
        });

        Schema::table('book_schedules', function (Blueprint $table) {
            $table->dropColumn(['meeting_end_time', 'proposed_end_time']);
        });
    }
};
