<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('studentid')->nullable()->unique();
            $table->string('education_level')->nullable();
            $table->string('programme')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['studentid']);
            $table->dropColumn(['studentid', 'education_level', 'programme']);
        });
    }
};
