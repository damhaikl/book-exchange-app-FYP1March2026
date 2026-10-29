<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'studentid')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('studentid')->nullable();
            });
        }

        if (!Schema::hasIndex('users', ['studentid'], 'unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unique('studentid');
            });
        }

        foreach (['education_level', 'programme'] as $column) {
            if (!Schema::hasColumn('users', $column)) {
                Schema::table('users', function (Blueprint $table) use ($column) {
                    $table->string($column)->nullable();
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasIndex('users', ['studentid'], 'unique')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropUnique(['studentid']);
            });
        }

        $columns = array_filter(
            ['studentid', 'education_level', 'programme'],
            fn (string $column): bool => Schema::hasColumn('users', $column),
        );

        if ($columns !== []) {
            Schema::table('users', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
