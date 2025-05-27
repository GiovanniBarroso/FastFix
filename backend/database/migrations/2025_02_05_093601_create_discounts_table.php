<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion')->nullable();
            $table->boolean('activo')->default(true);
            $table->decimal('valor', 10, 2);
            $table->enum('tipo', ['porcentaje', 'fijo'])->default('fijo');
            $table->timestamp('inicio')->nullable();
            $table->timestamp('fin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
