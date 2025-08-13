<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Convert old string values to integers
        DB::table('definitions')
            ->where('is_active', 'active')
            ->update(['is_active' => 1]);

        DB::table('definitions')
            ->where('is_active', 'not active')
            ->update(['is_active' => 0]);

        // Optional: Set anything else to 0
        DB::table('definitions')
            ->whereNotIn('is_active', [0, 1])
            ->update(['is_active' => 0]);

        // Step 2: Change column type
        Schema::table('definitions', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('definitions', function (Blueprint $table) {
            $table->string('is_active')->default('active')->change();
        });
    }
};
