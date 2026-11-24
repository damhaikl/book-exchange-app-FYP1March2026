
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_exchange_preferences', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')
                ->constrained('books')
                ->cascadeOnDelete();

            $table->string('wanted_subject_id');
            $table->string('wanted_book_name');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_exchange_preferences');
    }
};
