<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('description')->nullable();
            $table->decimal('precio', 10, 2);
            $table->integer('stock');
            $table->boolean('activo')->default(true);
            $table->foreignId('categories_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('brands_id')->constrained('brands')->onDelete('cascade');
            $table->string('image')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};
