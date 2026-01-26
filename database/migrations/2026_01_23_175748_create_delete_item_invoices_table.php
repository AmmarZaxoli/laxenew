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
        Schema::create('delete_item_invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sell_invoice_id'); // Foreign key column
            $table->integer('product_id');
            $table->integer('quantity');
            $table->decimal('price', 12, 2)->default(0);

            // Correct foreign key syntax
            $table->foreign('sell_invoice_id')
                ->references('id')
                ->on('delete_invoices')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delete_item_invoices');
    }
};
