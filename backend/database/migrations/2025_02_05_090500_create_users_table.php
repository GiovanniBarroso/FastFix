<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('apellidos', 100)->nullable();
            $table->string('email', 150)->unique();
            $table->timestamp('email_verified_at')->nullable(); // 🔹 Agregado para la verificación de correo
            $table->string('password', 255);
            $table->string('telefono', 15)->nullable();
            $table->timestamp('fecha_registro')->useCurrent();
            $table->unsignedBigInteger('role_id')->default(2);
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
