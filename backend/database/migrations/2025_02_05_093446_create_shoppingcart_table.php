<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shoppingcart', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_creacion')->useCurrent();
            $table->enum('estado', ['pendiente', 'procesado', 'cancelado'])->default('pendiente');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shoppingcart');
    }
};
