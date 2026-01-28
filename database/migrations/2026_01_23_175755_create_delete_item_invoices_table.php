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
            $table->unsignedBigInteger('id_delete_invoices'); 
            $table->string('product_id');
            $table->integer('quantity');
            $table->decimal('price', 12, 2)->default(0);

            // Correct foreign key syntax
            $table->foreign('id_delete_invoices')
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
