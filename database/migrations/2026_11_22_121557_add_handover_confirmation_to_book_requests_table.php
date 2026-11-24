<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->boolean('requester_confirmed_handover')
                ->default(false);

            $table->boolean('owner_confirmed_handover')
                ->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->dropColumn([
                'requester_confirmed_handover',
                'owner_confirmed_handover',
            ]);
        });
    }
};