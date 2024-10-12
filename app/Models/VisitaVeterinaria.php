<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitaVeterinaria extends Model
{
    use HasFactory;

    protected $table = 'visitas_veterinarias';

    public function mascota()
    {
        return $this->belongsTo(Mascota::class, 'mascota_id');
    }

}

