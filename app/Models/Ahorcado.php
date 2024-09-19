<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ahorcado extends Model
{
    use HasFactory;
        // Especificamos el nombre de la tabla
        protected $table = 'ahorcado';

        // Permitimos que estos campos se puedan asignar masivamente
        protected $fillable = [
            'palabra',
            'letras_adivinadas',
            'intentos_restantes',
        ];
    /*
        // Si deseas desactivar las marcas de tiempo
        public $timestamps = true;
    
        // Definimos que las columnas de tipo JSON deben ser casteadas automáticamente
        protected $casts = [
            'letras_adivinadas' => 'array',  // Casteamos a un array
        ];
    */
}
