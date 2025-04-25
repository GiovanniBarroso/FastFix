<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shoppingcart_products', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->foreignId('shoppingcart_id')->constrained('shoppingcart')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shoppingcart_products');
    }
};
