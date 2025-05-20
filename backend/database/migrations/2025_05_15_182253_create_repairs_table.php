<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('device_type'); // Móvil, tablet, consola, etc.
            $table->string('name'); // Descripción concreta del objeto a reparar
            $table->text('problem_description');
            $table->text('repair_notes')->nullable();

            $table->enum('status', ['pendiente', 'en progreso', 'terminado', 'entregado'])->default('pendiente');
            $table->enum('garantia', ['sin', '3m', '6m'])->default('sin');

            $table->decimal('repair_cost', 10, 2)->nullable();
            $table->dateTime('received_at')->nullable();
            $table->dateTime('delivered_at')->nullable();

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('repairs');
    }
};
