<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuqueFua extends Model
{
    use HasFactory;

    protected $table = 'buque_fua'; // Asegúrate de que este nombre sea correcto

    protected $fillable = [
        'buque_id',
        'roh_1',
        'roh_3',
        'roh_5',
        'mant_basico_1',
        'mant_intermedio_3',
        'mant_basico_3',
        'mant_mayor_5',
        'disponible_misiones_1',
        'disponibilidad_mantenimiento_1',
        'disponible_misiones_3',
        'disponibilidad_mantenimiento_3',
        'disponible_misiones_5',
        'disponibilidad_mantenimiento_5',
    ];
}
