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
        Schema::create('book_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('book_id')->constrained()->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('location');
            $table->date('meeting_date');
            $table->time('meeting_time');

            // status system for negotiation
            $table->enum('status', [
                'available', 
                'requested', 
                'accepted', 
                'proposed_change', 
                'approved_change', 
                'rejected', 
                'cancelled'
            ])->default('available');

            // buyer proposal (if change requested)
            $table->string('proposed_location')->nullable();
            $table->date('proposed_date')->nullable();
            $table->time('proposed_time')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_schedules');
    }
};
