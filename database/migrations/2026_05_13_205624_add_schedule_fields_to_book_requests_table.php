<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {

            $table->string('proposed_location')->nullable();
            $table->date('proposed_date')->nullable();
            $table->time('proposed_time')->nullable();

            $table->string('schedule_type')->default('seller');

        });
    }

    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {

            $table->dropColumn([
                'proposed_location',
                'proposed_date',
                'proposed_time',
                'schedule_type'
            ]);

        });
    }
};