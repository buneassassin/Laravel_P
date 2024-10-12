<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Veterinario extends Model
{
    use HasFactory;

    protected $table = 'veterinarios';

    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'veterinario_id');
    }
    public function clitas()
    {
        return $this->hasMany(Cita::class, 'veterinario_id');
    }
    
}
