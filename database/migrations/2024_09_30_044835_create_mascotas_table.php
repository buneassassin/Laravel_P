<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
           $table->foreignId('dueño_id')->constrained('dueños')->onDelete('cascade'); // Relación con dueños}
            $table->foreignId('vacuna_id')->constrained('vacunas')->onDelete('cascade'); // Relación con vacunas
            $table->foreignId('raza_id')->constrained('razas')->onDelete('cascade'); // Verifica que 'razas' exista 
            $table->date('fecha_nacimiento');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mascotas');
    }
};
