<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('description')->nullable();
            $table->boolean('activo')->default(true); // 👈 Nuevo campo
            $table->timestamps();
        });
        
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
