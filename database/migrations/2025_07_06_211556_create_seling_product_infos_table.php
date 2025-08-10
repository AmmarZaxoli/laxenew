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
        Schema::create('seling_product_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('quantity_sold');
            $table->integer('buy_price');
            $table->decimal('total_sell', 10);
            $table->decimal('profit', 10);
            $table->integer('sub_id');

            $table->unsignedBigInteger(column: 'sell_invoice_id');

            $table->foreign(columns: 'sell_invoice_id')->references('id')->on('sell_invoices')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seling_product_infos');
    }
};
