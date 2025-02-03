<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mision extends Model
{
    use HasFactory;

    protected $fillable = ['buque_id', 'mision'];

    protected $table = 'misiones'; // Asegúrate de que está apuntando a la tabla correcta
}