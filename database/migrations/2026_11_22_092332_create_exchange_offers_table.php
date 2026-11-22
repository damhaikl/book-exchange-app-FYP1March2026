
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_offers', function (Blueprint $table) {
            $table->id();

            // The exchange request this offer belongs to
            $table->foreignId('book_request_id')
                ->constrained('book_requests')
                ->cascadeOnDelete();

            // Existing book listing, if the student selected one
            $table->foreignId('offered_book_id')
                ->nullable()
                ->constrained('books')
                ->nullOnDelete();

            // Snapshot of the book being offered
            $table->string('title');
            $table->string('subject_id');
            $table->string('condition');
            $table->string('image')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_offers');
    }
};
