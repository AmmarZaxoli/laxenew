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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('mobile');
            $table->string('address');
            $table->dateTime('date_sell');
            $table->decimal('profit_invoice', 10);
            $table->decimal('profit_invoice_after_discount', 10);
            $table->boolean('is_block')->default(false);
            $table->string('note')->nullable();

            

            $table->unsignedBigInteger('sell_invoice_id');
            $table->unsignedBigInteger('driver_id');
            $table->foreign('sell_invoice_id')->references('id')->on('sell_invoices')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('drivers')->onUpdate('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
