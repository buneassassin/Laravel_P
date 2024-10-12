<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Raza extends Model
{
    use HasFactory;

    protected $table = 'razas';

    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'raza_id');
    }
}

