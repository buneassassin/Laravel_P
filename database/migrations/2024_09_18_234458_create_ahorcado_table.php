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
        Schema::create('ahorcado', function (Blueprint $table) {
            $table->id();
            $table->string('palabra'); // Aquí se guarda la palabra a adivinar
            $table->json('letras_adivinadas')->nullable(); // Aquí se guardan las letras adivinadas
            $table->unsignedTinyInteger('intentos_restantes')->default(6); // Intentos restantes
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
        Schema::dropIfExists('ahorcado');
    }
};
