<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuqueMision extends Model
{
    use HasFactory;

    // Agrega esta línea para especificar el nombre de la tabla
    protected $table = 'buque_misiones';

    protected $fillable = [
        'buque_id',
        'mision',
        'velocidad',
        'num_motores',
        'potencia',
        'porcentaje',
        'descripcion',
    ];

    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }
}

