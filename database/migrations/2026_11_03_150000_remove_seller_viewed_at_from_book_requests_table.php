<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('book_requests', 'seller_viewed_at')) {
            Schema::table('book_requests', function (Blueprint $table) {
                $table->dropColumn('seller_viewed_at');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('book_requests', 'seller_viewed_at')) {
            Schema::table('book_requests', function (Blueprint $table) {
                $table->timestamp('seller_viewed_at')->nullable()->after('status');
            });
        }
    }
};
