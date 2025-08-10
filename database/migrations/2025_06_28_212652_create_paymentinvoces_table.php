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
        Schema::create('paymentinvoces', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_payment');
            $table->decimal('cashpayment', 10, 2);
            $table->unsignedBigInteger('invoce_id');
            $table->foreign('invoce_id')->references('id')->on('buy_invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paymentinvoces');
    }
};
