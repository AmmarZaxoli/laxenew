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
        Schema::create('offer_sells', function (Blueprint $table) {
            $table->id();
            $table->string('nameoffer');
            $table->string('code');
            $table->integer('quantity');
            $table->decimal('price', 10);
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
        Schema::dropIfExists('offer_sells');
    }
};
