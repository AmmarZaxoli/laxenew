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
        Schema::create('sub_buy_products_invoices', function (Blueprint $table) {
             $table->id();
            $table->foreignId('product_id');
            $table->string('name');
            $table->string('barcode');
            $table->string('code');
            $table->foreignId('type_id');
            $table->dateTime('datecreate');
            $table->integer('quantity');
            $table->decimal('buy_price', 10, 2);
            $table->decimal('sell_price', 10, 2);
            $table->decimal('profit', 10, 2);
            $table->date('dateex')->nullable();
            $table->integer('q_sold')->default(0);
            $table->unsignedBigInteger('num_invoice_id');
            $table->foreign('num_invoice_id')->references('id')->on('buy_invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('buy_product_invoice_id');
            $table->foreign('buy_product_invoice_id')->references('id')->on('buy_products_invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_buy_products_invoices');
    }
};
