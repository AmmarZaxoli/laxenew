<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubOffersTable extends Migration
{
    public function up()
    {
        Schema::create('sub_offers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('offer_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            $table->integer('quantity')->default(1);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sub_offers');
    }
}
