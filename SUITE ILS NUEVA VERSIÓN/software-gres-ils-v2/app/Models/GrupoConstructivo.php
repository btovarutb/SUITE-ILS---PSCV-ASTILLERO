<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoConstructivo extends Model
{
    use HasFactory;

    protected $table = 'grupos_constructivos'; // Especifica la tabla si el nombre no es plural estándar

    protected $fillable = [
        'codigo',
        'nombre',
    ];

    /**
     * Relación con sistemas_suite.
     */
    public function sistemas()
    {
        return $this->hasMany(SistemaSuite::class, 'grupo_constructivo_id');
    }
}
