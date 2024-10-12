<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClinicaVeterinaria extends Model
{
    use HasFactory;

    protected $table = 'clínicas_veterinarias';

    public function citas()
    {
        return $this->hasMany(Cita::class, 'clínica_id');
    }
}
