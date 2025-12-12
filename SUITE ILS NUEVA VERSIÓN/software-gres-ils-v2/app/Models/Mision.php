<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mision extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada
     */
    protected $table = 'misiones'; // Especifica el nombre correcto de la tabla

    /**
     * Campos que se pueden asignar de forma masiva
     */
    protected $fillable = ['nombre', 'descripcion'];

}
