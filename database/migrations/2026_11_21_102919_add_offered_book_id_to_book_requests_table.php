
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->foreignId('offered_book_id')
                ->nullable()
                ->after('book_id')
                ->constrained('books')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->dropForeign(['offered_book_id']);
            $table->dropColumn('offered_book_id');
        });
    }
};
