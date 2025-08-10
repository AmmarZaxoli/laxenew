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
        Schema::create('buy_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('num_invoice');
            $table->string('name_invoice')->nullable();
            $table->datetime('datecreate');
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->decimal('cash', 10, 2)->default(0);
            $table->decimal('afterDiscountTotalPrice', 10, 2)->default(0);
            $table->decimal('residual', 10, 2)->default(0);
            $table->string('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buy_invoice');
    }
};
