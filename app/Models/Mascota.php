<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $table = 'mascotas';
    public function vacuna(){
        return $this->belongsTo(Vacuna::class, 'vacuna_id');
    }
    public function dueño()
    {
        return $this->belongsTo(Dueño::class, 'dueño_id');
    }

    public function raza()
    {
        return $this->belongsTo(Raza::class, 'raza_id');
    }

    public function historialMedico()
    {
        return $this->hasMany(HistorialMedico::class, 'mascota_id');
    }

    public function visitasVeterinarias()
    {
        return $this->hasMany(VisitaVeterinaria::class, 'mascota_id');
    }
}
