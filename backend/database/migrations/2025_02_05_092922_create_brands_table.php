<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('description')->nullable();
            $table->boolean('activo')->default(true); // 👈 añadido
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('brands');
    }
};
