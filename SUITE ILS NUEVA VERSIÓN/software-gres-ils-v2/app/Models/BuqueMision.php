<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuqueMision extends Model
{
    use HasFactory;

    protected $fillable = ['buque_id', 'mision_id', 'porcentaje', 'descripcion'];

    // Relación con Buque
    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }

    // Relación con Mision
    public function mision()
    {
        return $this->belongsTo(Mision::class);
    }
}
