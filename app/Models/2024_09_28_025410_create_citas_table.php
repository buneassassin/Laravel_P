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
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mascota_id')->constrained('mascotas')->onDelete('cascade');   // Relación con mascotas
            $table->foreignId('veterinario_id')->constrained('veterinarios')->onDelete('cascade'); // Relación con veterinarios
            $table->foreignId('clínica_id')->constrained('clínicas_veterinarias')->onDelete('cascade'); // Relación con clínicas veterinarias
            $table->date('fecha_cita');
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
        Schema::dropIfExists('citas');
    }
};
