<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('reviewed_user_id')
                ->nullable()
                ->after('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('book_request_id')
                ->nullable()
                ->after('reviewed_user_id')
                ->constrained('book_requests')
                ->cascadeOnDelete();

            $table->unique(
                ['book_request_id', 'user_id'],
                'reviews_request_user_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique('reviews_request_user_unique');

            $table->dropConstrainedForeignId('book_request_id');
            $table->dropConstrainedForeignId('reviewed_user_id');
        });
    }
};