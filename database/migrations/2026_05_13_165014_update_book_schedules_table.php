<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('book_schedules', function (Blueprint $table) {
            $table->string('location')->change();
            $table->date('meeting_date')->change();
            $table->time('meeting_time')->change();

            $table->foreignId('buyer_id')->nullable()->change();

            $table->enum('status', ['available', 'requested', 'accepted', 'rejected'])
            ->default('available')
            ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
