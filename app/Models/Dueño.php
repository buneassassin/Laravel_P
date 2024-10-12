<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Dueño extends Model
{
    use HasFactory;

    protected $table = 'dueños';
    public function mascotas()
    {
        return $this->hasMany(Mascota::class, 'dueño_id');
    }
}

