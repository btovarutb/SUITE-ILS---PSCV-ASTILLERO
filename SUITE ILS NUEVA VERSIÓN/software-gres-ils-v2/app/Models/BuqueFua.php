<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuqueFua extends Model
{
    use HasFactory;

    protected $table = 'buque_fua';

    protected $fillable = [
        'buque_id',
        'roh_1',
        'mant_basico_1',
        'disponible_misiones_1',
        'disponibilidad_mantenimiento_1',
        'puerto_extranjero'
    ];

    public function buque()
    {
        return $this->belongsTo(Buque::class);
    }
} 