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
        Schema::create('delete_invoices', function (Blueprint $table) {
            $table->id();
            $table->decimal('totalprice', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->string('customermobile')->nullable();
            $table->string('address')->nullable();
            $table->string('user')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deleteinvoices');
    }
};
