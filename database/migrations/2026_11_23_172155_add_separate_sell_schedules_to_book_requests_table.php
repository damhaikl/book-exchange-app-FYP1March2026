<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {

            // Student A (Buyer) proposed schedule
            $table->string('buyer_proposed_location')->nullable();
            $table->date('buyer_proposed_date')->nullable();
            $table->time('buyer_proposed_time')->nullable();
            $table->time('buyer_proposed_end_time')->nullable();

            // Student B (Seller) proposed schedule
            $table->string('seller_proposed_location')->nullable();
            $table->date('seller_proposed_date')->nullable();
            $table->time('seller_proposed_time')->nullable();
            $table->time('seller_proposed_end_time')->nullable();

        });

        // Preserve existing buyer proposals
        DB::table('book_requests')
            ->where('schedule_type', 'buyer')
            ->whereNotNull('proposed_location')
            ->update([
                'buyer_proposed_location' => DB::raw('proposed_location'),
                'buyer_proposed_date' => DB::raw('proposed_date'),
                'buyer_proposed_time' => DB::raw('proposed_time'),
                'buyer_proposed_end_time' => DB::raw('proposed_end_time'),
            ]);

        // Preserve existing seller proposals
        DB::table('book_requests')
            ->where('schedule_type', 'seller')
            ->whereNotNull('proposed_location')
            ->update([
                'seller_proposed_location' => DB::raw('proposed_location'),
                'seller_proposed_date' => DB::raw('proposed_date'),
                'seller_proposed_time' => DB::raw('proposed_time'),
                'seller_proposed_end_time' => DB::raw('proposed_end_time'),
            ]);
    }

    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->dropColumn([
                'buyer_proposed_location',
                'buyer_proposed_date',
                'buyer_proposed_time',
                'buyer_proposed_end_time',
                'seller_proposed_location',
                'seller_proposed_date',
                'seller_proposed_time',
                'seller_proposed_end_time',
            ]);
        });
    }
};
