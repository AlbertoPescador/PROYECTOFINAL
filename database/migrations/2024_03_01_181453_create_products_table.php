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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name',40)->nullable(false);
            $table->string('description',500);
            $table->float('stock')->nullable(false);
            $table->boolean('sale')->nullable(false);
            $table->float('priceKG')->nullable(false);
            $table->string('urlImagen')->nullable(false);
            $table->float('priceSale')->nullable(true)->defaut(0);
            $table->float('priceKGFinal')->default(0);
            $table->string('cutType')->nullable(true);
            $table->unsignedBigInteger('category_id')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
