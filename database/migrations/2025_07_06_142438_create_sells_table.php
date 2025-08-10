<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->decimal('taxi_price',10);
            $table->decimal('total_Price_invoice',10);
            $table->decimal('discount',10);
            $table->decimal('total_price_afterDiscount_invoice',10);
            $table->boolean('cash')->default(false);
            $table->string('user')->Nullable();



            $table->unsignedBigInteger('sell_invoice_id');

            $table->foreign('sell_invoice_id')->references('id')->on('sell_invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells');
    }
};
