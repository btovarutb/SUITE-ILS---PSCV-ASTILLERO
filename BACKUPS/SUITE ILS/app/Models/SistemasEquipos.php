<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SistemasEquipos extends Model
{
    use HasFactory;

    protected $table = 'sistemas_equipos';

    protected $fillable = [
        'mfun',
        'titulo',
    ];

    public $timestamps = false; // Desactivar timestamps

    public function buques()
    {
        return $this->belongsToMany(Buque::class, 'buque_sistemas_equipos')
            ->withPivot('mec', 'diagrama_id')
            ->withTimestamps();
    }
}
