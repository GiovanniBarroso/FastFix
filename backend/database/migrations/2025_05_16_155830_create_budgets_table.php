<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('budgets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('mensaje');
            $table->enum('estado', ['pendiente', 'respondido', 'rechazado'])->default('pendiente');
            $table->text('respuesta_admin')->nullable();
            $table->decimal('presupuesto_estimado', 10, 2)->nullable();
            $table->timestamp('fecha_respuesta')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('budgets');
    }
};
