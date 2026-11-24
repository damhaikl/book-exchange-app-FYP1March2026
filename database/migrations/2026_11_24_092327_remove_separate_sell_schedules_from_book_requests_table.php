
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::table('book_requests', function (Blueprint $table) {
            $table->string('buyer_proposed_location')->nullable();
            $table->date('buyer_proposed_date')->nullable();
            $table->time('buyer_proposed_time')->nullable();
            $table->time('buyer_proposed_end_time')->nullable();

            $table->string('seller_proposed_location')->nullable();
            $table->date('seller_proposed_date')->nullable();
            $table->time('seller_proposed_time')->nullable();
            $table->time('seller_proposed_end_time')->nullable();
        });
    }
};
