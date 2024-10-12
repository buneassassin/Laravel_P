<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;

    protected $table = 'vacunas';
    
    public function mascotas(){
        return $this->hasMany(Mascota::class, 'vacuna_id');
    }
}
