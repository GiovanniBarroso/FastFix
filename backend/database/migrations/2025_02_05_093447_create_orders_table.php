<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'pagado', 'cancelado'])->default('pendiente');
            $table->string('metodo_pago')->nullable();
            $table->string('paypal_payment_id')->nullable();
            $table->string('paypal_status')->nullable();
            $table->timestamp('fecha_pago')->nullable();
            $table->text('notas_cliente')->nullable();
            $table->text('notas_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
