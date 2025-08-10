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
        Schema::create('selling_products', function (Blueprint $table) {
              $table->id();
            $table->string('name');
            $table->string('code');
            $table->string('barcode');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->decimal('total_price', 10, 2);

            $table->unsignedBigInteger('type_id');
            $table->unsignedBigInteger('product_id');
            // $table->unsignedBigInteger('sub_Buy_Products_invoice');
            $table->unsignedBigInteger(column: 'sell_invoice_id');

            // Foreign key constraints
           
            $table->foreign(columns: 'sell_invoice_id')->references('id')->on('sell_invoices')->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selling_products');
    }
};
