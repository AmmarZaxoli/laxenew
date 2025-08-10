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
        Schema::create('sell_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('num_invoice_sell')->unique();
            $table->decimal('total_price', 10)->default(0);
            $table->boolean('selling')->default(false);
            $table->dateTime('date_sell');//this column

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_invoices');
        
    }
};
