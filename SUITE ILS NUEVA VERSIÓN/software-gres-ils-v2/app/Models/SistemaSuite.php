<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemaSuite extends Model
{
    use HasFactory;

    protected $table = 'sistemas_suite'; // Especifica la tabla si el nombre no es plural estándar

    protected $fillable = [
        'grupo_constructivo_id',
        'codigo',
        'nombre',
        'descripcion',
    ];

    /**
     * Relación con grupo_constructivo.
     */
    public function grupoConstructivo()
    {
        return $this->belongsTo(GrupoConstructivo::class, 'grupo_constructivo_id');
    }

    public function buques()
    {
        return $this->belongsToMany(Buque::class, 'buque_sistema', 'sistema_id', 'buque_id');
    }

    public function equipos()
    {
        return $this->hasMany(EquipoSuite::class, 'sistema_id');
    }
}
