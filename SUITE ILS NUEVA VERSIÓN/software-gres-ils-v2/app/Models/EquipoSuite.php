<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoSuite extends Model
{
    use HasFactory;

    protected $table = 'equipos_suite';

    protected $fillable = [
        'id_equipo_info',
        'sistema_id',
        'codigo',
        'nombre',
        'descripcion',
    ];

    public function sistema()
    {
        return $this->belongsTo(SistemaSuite::class, 'sistema_id');
    }
} 