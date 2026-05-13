<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {

            $table->string('meeting_location')->nullable();
            $table->date('meeting_date')->nullable();
            $table->time('meeting_time')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {

            $table->dropColumn('meeting_location');
            $table->dropColumn('meeting_date');
            $table->dropColumn('meeting_time');

        });
    }
};