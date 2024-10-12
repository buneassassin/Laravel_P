<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

    public function veterinario()
    {
        return $this->belongsTo(Veterinario::class, 'veterinario_id');
    }

    public function clínica()
    {
        return $this->belongsTo(ClinicaVeterinaria::class, 'clínica_id');
    }
}

